<?php
if ( ! function_exists( 'wc_get_product' ) ) {
	return;
}

$crea_star = wc_get_product( crea_legacy_star_product_id() );

if ( ! $crea_star || ! $crea_star->is_visible() ) {
	return;
}

$crea_sales = (int) $crea_star->get_total_sales();
?>
<section class="star" aria-labelledby="titre-star">
	<div class="star__inner">
		<div class="star__media">
			<?php echo $crea_star->get_image( 'woocommerce_single', array( 'class' => 'star__image' ) ); ?>
			<span class="star-badge star__badge"><?php esc_html_e( 'Produit star', 'crea-legacy' ); ?></span>
		</div>
		<div class="star__content">
			<p class="star__kicker"><?php esc_html_e( 'Le plus commandé', 'crea-legacy' ); ?></p>
			<h2 class="title star__title" id="titre-star"><?php echo esc_html( $crea_star->get_name() ); ?></h2>
			<p class="star__text"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $crea_star->get_short_description() ), 30 ) ); ?></p>
			<p class="star__meta">
				<span class="star__price"><?php echo wp_kses_post( $crea_star->get_price_html() ); ?></span>
				<span class="star__sales"><?php echo esc_html( sprintf( _n( '%s vendu', '%s vendus', $crea_sales, 'crea-legacy' ), number_format_i18n( $crea_sales ) ) ); ?></span>
			</p>
			<a class="btn btn--more btn--cta" href="<?php echo esc_url( $crea_star->get_permalink() ); ?>"><?php esc_html_e( 'Je goûte', 'crea-legacy' ); ?><span class="visually-hidden"> : <?php echo esc_html( $crea_star->get_name() ); ?></span><?php echo crea_legacy_icon( 'chevron-right', 'btn__icon' ); ?></a>
		</div>
	</div>
</section>
