<?php
$crea_composition = $args['composition'] ?? '';
$crea_allergens   = $args['allergens'] ?? array();
$crea_nutrition   = $args['nutrition'] ?? array();
?>
<section class="product-infos" aria-labelledby="titre-infos">
	<h2 class="visually-hidden" id="titre-infos"><?php esc_html_e( 'Infos produit', 'crea-legacy' ); ?></h2>
	<?php if ( $crea_composition ) : ?>
		<div class="product-infos__block">
			<h3 class="product-infos__title"><?php esc_html_e( 'Composition', 'crea-legacy' ); ?></h3>
			<p class="product-infos__text"><?php echo esc_html( $crea_composition ); ?></p>
		</div>
	<?php endif; ?>
	<?php if ( $crea_allergens ) : ?>
		<div class="product-infos__block">
			<h3 class="product-infos__title"><?php esc_html_e( 'Allergènes', 'crea-legacy' ); ?></h3>
			<ul class="product-infos__tags">
				<?php foreach ( $crea_allergens as $crea_allergen ) : ?>
					<li class="tag"><?php echo esc_html( $crea_allergen ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
	<?php if ( $crea_nutrition ) : ?>
		<details class="product-infos__block product-infos__details">
			<summary class="product-infos__title product-infos__summary"><?php esc_html_e( 'Valeurs nutritionnelles', 'crea-legacy' ); ?><?php echo crea_legacy_icon( 'chevron-down', 'product-infos__icon' ); ?></summary>
			<table class="nutrition">
				<caption class="visually-hidden"><?php esc_html_e( 'Valeurs nutritionnelles par portion', 'crea-legacy' ); ?></caption>
				<tbody>
					<?php foreach ( $crea_nutrition as $crea_row ) : ?>
						<tr class="nutrition__row">
							<th class="nutrition__label" scope="row"><?php echo esc_html( $crea_row['label'] ); ?></th>
							<td class="nutrition__value"><?php echo esc_html( $crea_row['value'] ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</details>
	<?php endif; ?>
</section>
