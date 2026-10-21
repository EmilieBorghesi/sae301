<?php
if ( ! function_exists( 'wc_get_products' ) ) {
	return;
}

$crea_products = crea_legacy_latest_products();

if ( ! $crea_products ) {
	return;
}
?>
<section class="latest" aria-labelledby="titre-nouveautes">
	<div class="latest__head">
		<h2 class="title latest__title" id="titre-nouveautes"><?php esc_html_e( 'Nouveautés', 'crea-legacy' ); ?></h2>
		<p class="subtitle"><?php esc_html_e( 'Les dernières recettes arrivées au comptoir.', 'crea-legacy' ); ?></p>
	</div>
	<ul class="products columns-3 latest__grid">
		<?php
		foreach ( $crea_products as $crea_product ) {
			$GLOBALS['post'] = get_post( $crea_product->get_id() );
			setup_postdata( $GLOBALS['post'] );
			wc_get_template_part( 'content', 'product' );
		}
		wp_reset_postdata();
		?>
	</ul>
</section>
