# Mise en production

Process pour mettre à jour la prod (mmi.unilim.fr) après des changements faits en local dans Local.

Remplace `TON_LOGIN`, `TON_DOSSIER` et `TON_URL` par tes valeurs. Exemple : `TON_URL` = `https://mmi.unilim.fr/~TON_LOGIN/sae301`.

## 1. Première mise en ligne (IT-1)

1. **WordPress neuf** sur le serveur, dans `~/public_html/TON_DOSSIER` (dernière version de wordpress.org).
2. **wp-config.php** fait à la main : nom de la base, utilisateur, mot de passe et hôte donnés par l'IUT, `$table_prefix = 'r3sae01_';`, nouvelles clés de sécurité (https://api.wordpress.org/secret-key/1.1/salt/).
3. **Fichiers** depuis ton ordi (Terminal), dans le dossier `app/public` de Local :
   ```
   scp -r wp-content/themes/storefront TON_LOGIN@mmi.unilim.fr:~/public_html/TON_DOSSIER/wp-content/themes/
   scp -r wp-content/plugins TON_LOGIN@mmi.unilim.fr:~/public_html/TON_DOSSIER/wp-content/
   scp -r wp-content/uploads TON_LOGIN@mmi.unilim.fr:~/public_html/TON_DOSSIER/wp-content/
   scp -r wp-content/languages TON_LOGIN@mmi.unilim.fr:~/public_html/TON_DOSSIER/wp-content/
   ```
4. **Thème enfant** depuis GitHub, en SSH sur le serveur :
   ```
   ssh TON_LOGIN@mmi.unilim.fr
   cd ~/public_html/TON_DOSSIER/wp-content/themes
   git clone https://github.com/TON_COMPTE/crea-legacy.git
   ```
5. **Base de données** : dans Local, **Open site shell** puis `wp db export ../base-locale.sql`. Envoie le fichier :
   ```
   scp ../base-locale.sql TON_LOGIN@mmi.unilim.fr:~/
   ```
   Puis en SSH :
   ```
   cd ~/public_html/TON_DOSSIER
   wp db import ~/base-locale.sql
   wp search-replace 'http://sae301.local' 'TON_URL' --all-tables-with-prefix --precise
   wp rewrite flush
   wp cache flush
   ```
   Si `wp` n'existe pas sur le serveur : `curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar` puis remplace `wp` par `php ~/wp-cli.phar`.
6. Vérifie le front (`TON_URL`) et le back office (`TON_URL/wp-admin`).

## 2. Mise à jour après une itération

| Ce qui a changé | Quoi faire |
| --- | --- |
| Code du thème | En local : `git add .`, `git commit -m "[IT-X] …"`, `git push`. Sur le serveur : `cd ~/public_html/TON_DOSSIER/wp-content/themes/crea-legacy && git pull` |
| Réglages SCF (type Équipe, taxonomie, groupes de champs, page d'options) | Modifie-les dans SCF en local : SCF met à jour `acf-json/` dans le thème. Commit + push comme le code, `git pull` sur le serveur, puis en prod : SCF > Groupes de champs (et Types de publication, Taxonomies, Pages d'options) > **Synchroniser**, ou `wp eval-file` du script `scf-sae301.php` |
| Nouvelle extension | `scp -r wp-content/plugins/NOM TON_LOGIN@mmi.unilim.fr:~/public_html/TON_DOSSIER/wp-content/plugins/` puis `wp plugin activate NOM` en SSH |
| Contenus, réglages, produits | Refaire l'étape 5 (export, import, search-replace). Attention : ça remplace les commandes et comptes créés en prod |
| Images | `scp -r wp-content/uploads …` comme à l'étape 3 |

Après chaque mise à jour : vide le cache du navigateur, teste un parcours (ajout au panier → commande) et note la mise en prod dans `journal-mises-en-production.md`.

## 3. Cache navigateur (Lighthouse, IT-Y)

Ajoute ces lignes au début du `.htaccess` à la racine du site en prod :

```
<IfModule mod_expires.c>
ExpiresActive On
ExpiresByType text/css "access plus 1 year"
ExpiresByType application/javascript "access plus 1 year"
ExpiresByType image/webp "access plus 1 year"
ExpiresByType image/jpeg "access plus 1 year"
ExpiresByType image/png "access plus 1 year"
ExpiresByType image/svg+xml "access plus 1 year"
ExpiresByType font/woff2 "access plus 1 year"
</IfModule>
<IfModule mod_deflate.c>
AddOutputFilterByType DEFLATE text/html text/css application/javascript image/svg+xml
</IfModule>
```

Lance ensuite Lighthouse (Chrome > Inspecter > Lighthouse) sur une fiche produit en navigation privée, mode Mobile puis Ordinateur, et enregistre le rapport HTML.
