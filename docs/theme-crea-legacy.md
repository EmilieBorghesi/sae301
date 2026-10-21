# Thème enfant crea-legacy

Thème enfant de Storefront pour le click & collect Emilie and the Cool Kids. Il reprend le Figma Borghesi (pages Prototypage et Design System).

## Installation

1. Storefront doit être installé. Copie `crea-legacy` dans `wp-content/themes/` (ou clone le dépôt GitHub à cet endroit).
2. Apparence > Thèmes : active **Crea Legacy**.
3. En local, les scripts `setup-sae301.php` puis `contenu-sae301.php` font tous les réglages (voir le guide `wordpress-local/README.md`).
4. Secure Custom Fields (SCF) doit être actif : le type Équipe, la taxonomie Moments, les groupes de champs et la page « Réglages du site » sont créés avec SCF (voir plus bas).

## Fonctionnalités par itération

| IT | Ce que fait le thème | Fichiers |
| --- | --- | --- |
| 1 | Thème enfant, design system, page d'options SCF « Réglages du site » (page Click & Collect, liens du pied de page) | `style.css`, `functions.php`, `inc/`, `assets/`, `acf-json/ui_options_page_crea_reglages.json`, `acf-json/group_crea_site.json` |
| 2 | En-tête, pied de page, accueil (contenus dans des champs SCF de la page Accueil), boutique, fiche produit, page Click & Collect | `header.php`, `footer.php`, `front-page.php`, `template-click-collect.php`, `template-parts/`, `inc/woocommerce.php`, `acf-json/group_crea_home.json` |
| 3 | Options des produits variables en boutons + prix « Dès » | `inc/woocommerce.php`, `assets/js/options.js` |
| 4 | Groupe de champs SCF **Infos produit** (Composition, Allergènes, Valeurs nutritionnelles), affiché avant le prix | `acf-json/group_crea_product_infos.json`, `inc/product-fields.php`, `template-parts/product/infos.php` |
| 5 | Panier : mise à jour auto des quantités, lien « Retirer du panier » | `woocommerce/cart/cart.php`, `assets/js/cart.js` |
| 6 | Bloc « Instructions pour le retrait » au checkout (si retrait choisi) et sur la page merci, texte dans le groupe SCF **Retrait en boutique** | `acf-json/group_crea_pickup.json`, `inc/pickup.php` |
| 7 | Espace client : menu en tutoiement, accueil du compte | `inc/account.php` |
| 8 | E-mails aux couleurs : logo, bandeau, pied de page, instructions de retrait | `woocommerce/emails/`, `inc/emails.php` |
| 9 | Statut « Prête à retirer », e-mail associé, suivi de commande (merci + Mon compte) | `inc/orders.php`, `inc/class-crea-legacy-email-ready-pickup.php`, `template-parts/order/` |
| 10 | Libellé « Code promo », messages des codes en tutoiement | `inc/promotions.php` |
| 11 | Type de publication **Équipe** créé avec SCF (page liste `/equipe/` + page par membre) et groupe de champs SCF **Profil** | `acf-json/post_type_crea_member.json`, `acf-json/group_crea_member.json`, `inc/team.php`, `archive-crea_member.php`, `single-crea_member.php` |
| 12 | Taxonomie **Moments** créée avec SCF (Petit-déj, Déjeuner, Goûter), pages `/moment/…/` | `acf-json/taxonomy_crea_moment.json`, `inc/taxonomy.php` |
| 13 | Ventes croisées : « Tu vas aimer aussi » (fiche) et « Pour compléter ta commande » (panier) | `inc/woocommerce.php` |
| 14 | Avis : formulaire « Donne ton avis », onglet « Avis (n) », étoiles aux couleurs | `inc/reviews.php` |
| 15 | Frais de préparation sous un seuil, réglables dans le groupe SCF **Frais de préparation**, avec message « Plus que X € » | `acf-json/group_crea_fees.json`, `inc/fees.php` |
| 16 | Accueil : 3 derniers produits ajoutés | `inc/home.php`, `template-parts/home/latest.php` |
| W | Produit star (le plus vendu) : bloc d'accueil + badge sur les cartes et la fiche | `inc/home.php`, `template-parts/home/star.php` |
| X | Anti-spam invisible (champ piège + délai minimal) sur l'inscription et les avis | `inc/antispam.php` |
| Y | Polices locales, CSS inutiles retirés, icônes chargées en différé, scripts en bas de page, image principale prioritaire et visible sans attendre le JS, WebP auto, meta description | `inc/performance.php` |

## Réglages dans le back office

| Où | Quoi |
| --- | --- |
| **Réglages du site** (page d'options SCF) | Page Click & Collect, liens « Accès franchisé », Facebook, Instagram, instructions de retrait, libellé, montant et seuil des frais de préparation |
| WooCommerce > Réglages > Livraison > Zones | Zone France : retrait gratuit, livraison Nice 4,90 €, express 7,90 € |
| WooCommerce > Réglages > Paiements | Virement bancaire et Paiement au retrait (limité au retrait en boutique) |
| WooCommerce > Commandes | Statut **Prête à retirer** dans la liste des statuts et dans les actions groupées |
| WooCommerce > Réglages > E-mails | Sujets et titres en tutoiement, e-mail « Commande prête à retirer » |
| Marketing > Codes promo | `COOL10`, `MATCHA1`, `RENTREE` (expiré) |
| Équipe | Ajouter un membre : nom, photo (image mise en avant), poste, coffee shop, année, citation, produit préféré |
| Produits > Moments | Les termes de la taxonomie et leur description |
| Apparence > Menus | Menu principal, Pied de page 1 et 2, Coffee shops (le menu déroulant n'apparaît que s'il contient des liens) |
| Pages > Accueil | Bloc SCF **Contenu de l'accueil** : onglets Haut de page (vidéo, image), La carte (phrase), Franchise (titre, texte, bouton, visuel) |
| SCF | Types de publication, Taxonomies, Groupes de champs, Pages d'options : tout ce qui est personnalisé se modifie ici |
| Produits > fiche produit | Description courte = texte des cartes. Bloc **Infos produit** sous l'éditeur = composition, allergènes, valeurs nutritionnelles |

## Secure Custom Fields

Tout ce qui est personnalisé est créé avec l'extension SCF, sans `register_post_type()`, `register_taxonomy()` ni `acf_add_local_field_group()` dans le code :

| SCF > | Élément | Fichier JSON |
| --- | --- | --- |
| Pages d'options | Réglages du site (`crea-reglages`) | `ui_options_page_crea_reglages.json` |
| Types de publication | Équipe (`crea_member`) | `post_type_crea_member.json` |
| Taxonomies | Moments (`crea_moment`, sur les produits) | `taxonomy_crea_moment.json` |
| Groupes de champs | Pages et liens, Retrait en boutique, Frais de préparation (sur Réglages du site) | `group_crea_site.json`, `group_crea_pickup.json`, `group_crea_fees.json` |
| Groupes de champs | Contenu de l'accueil (page d'accueil) | `group_crea_home.json` |
| Groupes de champs | Infos produit (produits) | `group_crea_product_infos.json` |
| Groupes de champs | Profil (Équipe) | `group_crea_member.json` |

- Le dossier `acf-json/` est le « JSON local » de SCF : SCF y enregistre chaque modification faite dans son back office, ce qui les versionne avec Git.
- Après un `git pull` qui change ces fichiers, SCF affiche **Synchronisation disponible** dans la liste : clique sur **Synchroniser** (ou relance `wp eval-file wordpress-local/scf-sae301.php`).
- Le PHP du thème ne fait que lire les valeurs (`get_field()`), par exemple `crea_legacy_mod()` dans `inc/helpers.php` et `crea_legacy_cc_option()` dans `inc/pickup.php`.

## Organisation

- `functions.php` charge `inc/` (un fichier par fonctionnalité).
- `acf-json/` : définitions SCF (voir plus haut).
- `header.php` et `footer.php` remplacent ceux de Storefront ; le contenu est dans `template-parts/`.
- `assets/css` : `variables` (variables Figma), `base` (polices, bases), `components`, `layout`, `woocommerce`.
- `woocommerce/` : seulement les gabarits surchargés (panier, en-tête et pied des e-mails, e-mail « prête à retirer »).
- Panier et Commande restent en shortcodes classiques.
- Polices : Eighty Miles et Raleway (licence OFL, `assets/fonts/raleway-OFL.txt`) servies par le thème.
