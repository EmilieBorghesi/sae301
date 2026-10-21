<?php

function crea_legacy_star_product_id() {
	$cached = get_transient( 'crea_legacy_star_product' );

	if ( false !== $cached ) {
		return (int) $cached;
	}

	$ids = get_posts(
		array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => 'total_sales',
			'orderby'        => array(
				'meta_value_num' => 'DESC',
				'date'           => 'DESC',
			),
			'meta_query'     => array(
				array(
					'key'     => 'total_sales',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'NUMERIC',
				),
			),
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => array( 'exclude-from-catalog' ),
					'operator' => 'NOT IN',
				),
			),
		)
	);

	$id = $ids ? (int) $ids[0] : 0;

	set_transient( 'crea_legacy_star_product', $id, HOUR_IN_SECONDS );

	return $id;
}

function crea_legacy_reset_star() {
	delete_transient( 'crea_legacy_star_product' );
}
add_action( 'woocommerce_recorded_sales', 'crea_legacy_reset_star' );
add_action( 'woocommerce_order_status_changed', 'crea_legacy_reset_star' );
add_action( 'save_post_product', 'crea_legacy_reset_star' );

function crea_legacy_is_star( $product ) {
	return $product && crea_legacy_star_product_id() === $product->get_id();
}

function crea_legacy_star_badge() {
	global $product;

	if ( crea_legacy_is_star( $product ) ) {
		printf( '<span class="star-badge">%s</span>', esc_html__( 'Produit star', 'crea-legacy' ) );
	}
}
add_action( 'woocommerce_before_shop_loop_item_title', 'crea_legacy_star_badge', 9 );
add_action( 'woocommerce_single_product_summary', 'crea_legacy_star_badge', 4 );

function crea_legacy_latest_products() {
	return wc_get_products(
		array(
			'status'     => 'publish',
			'limit'      => 3,
			'visibility' => 'catalog',
			'orderby'    => 'date',
			'order'      => 'DESC',
		)
	);
}
