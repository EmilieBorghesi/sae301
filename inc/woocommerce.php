<?php

function crea_legacy_woocommerce_hooks() {
	remove_action( 'woocommerce_before_shop_loop', 'storefront_sorting_wrapper', 9 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30 );
	remove_action( 'woocommerce_before_shop_loop', 'storefront_sorting_wrapper_close', 31 );
	remove_action( 'woocommerce_after_shop_loop', 'storefront_sorting_wrapper', 9 );
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'woocommerce_after_shop_loop', 'storefront_sorting_wrapper_close', 31 );

	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	add_action( 'woocommerce_shop_loop_item_title', 'crea_legacy_loop_title', 10 );
	add_action( 'woocommerce_after_shop_loop_item_title', 'crea_legacy_loop_excerpt', 7 );
	add_action( 'woocommerce_before_shop_loop', 'crea_legacy_shop_heading', 40 );

	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
	add_action( 'woocommerce_before_single_product', 'crea_legacy_back_link', 5 );
}
add_action( 'init', 'crea_legacy_woocommerce_hooks' );

function crea_legacy_loop_title() {
	printf( '<h3 class="woocommerce-loop-product__title">%s</h3>', esc_html( get_the_title() ) );
}

function crea_legacy_loop_excerpt() {
	global $product;

	$text = $product ? wp_strip_all_tags( $product->get_short_description() ) : '';

	if ( $text ) {
		printf( '<p class="woocommerce-loop-product__desc">%s</p>', esc_html( wp_trim_words( $text, 22 ) ) );
	}
}

function crea_legacy_shop_heading() {
	if ( is_shop() && ! is_search() ) {
		printf( '<h2 class="title title--h2 shop-heading">%s</h2>', esc_html__( 'Tous les produits', 'crea-legacy' ) );
	} elseif ( is_product_taxonomy() || is_search() ) {
		printf( '<h2 class="visually-hidden">%s</h2>', esc_html__( 'Produits', 'crea-legacy' ) );
	}
}

function crea_legacy_back_link() {
	$referer = wp_get_referer();
	$url     = $referer ? $referer : wc_get_page_permalink( 'shop' );

	printf(
		'<a class="back" href="%1$s">%2$s%3$s</a>',
		esc_url( $url ),
		crea_legacy_icon( 'chevron-left', 'back__icon' ),
		esc_html__( 'Retour', 'crea-legacy' )
	);
}

function crea_legacy_add_to_cart_text( $text, $product ) {
	if ( $product->is_purchasable() && $product->is_in_stock() ) {
		return __( 'Ajouter au panier', 'crea-legacy' );
	}

	return $text;
}
add_filter( 'woocommerce_product_add_to_cart_text', 'crea_legacy_add_to_cart_text', 10, 2 );

function crea_legacy_related_args( $args ) {
	$args['posts_per_page'] = 3;
	$args['columns']        = 3;

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'crea_legacy_related_args', 20 );

function crea_legacy_related_heading() {
	return __( 'Produits similaires', 'crea-legacy' );
}
add_filter( 'woocommerce_product_related_products_heading', 'crea_legacy_related_heading' );
