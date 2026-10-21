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

	add_action( 'woocommerce_thankyou', 'crea_legacy_order_tracking', 5 );
	add_action( 'woocommerce_thankyou', 'crea_legacy_order_actions', 30 );
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

function crea_legacy_variable_price( $price, $product ) {
	$min = $product->get_variation_price( 'min', true );
	$max = $product->get_variation_price( 'max', true );

	if ( $min === $max ) {
		return $price;
	}

	return sprintf( '<span class="price__from">%1$s</span> %2$s', esc_html__( 'Dès', 'crea-legacy' ), wc_price( $min ) );
}
add_filter( 'woocommerce_variable_price_html', 'crea_legacy_variable_price', 10, 2 );

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

function crea_legacy_variation_options( $html, $args ) {
	$product   = $args['product'];
	$attribute = $args['attribute'];
	$options   = $args['options'];

	if ( empty( $options ) && $product ) {
		$attributes = $product->get_variation_attributes();
		$options    = $attributes[ $attribute ] ?? array();
	}

	if ( empty( $options ) || ! $product ) {
		return $html;
	}

	$select_id = $args['id'] ? $args['id'] : sanitize_title( $attribute );
	$choices   = array();

	if ( taxonomy_exists( $attribute ) ) {
		foreach ( wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) ) as $term ) {
			if ( in_array( $term->slug, $options, true ) ) {
				$choices[ $term->slug ] = apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product );
			}
		}
	} else {
		foreach ( $options as $option ) {
			$choices[ $option ] = apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product );
		}
	}

	if ( ! $choices ) {
		return $html;
	}

	$chips = '';

	foreach ( $choices as $value => $label ) {
		$chips .= sprintf(
			'<label class="option"><input class="option__input" type="radio" name="crea-%1$s" value="%2$s"%3$s><span class="option__label">%4$s</span></label>',
			esc_attr( $select_id ),
			esc_attr( $value ),
			checked( (string) $args['selected'], (string) $value, false ),
			esc_html( $label )
		);
	}

	return sprintf(
		'<div class="variation-field">%1$s<div class="options__list" role="radiogroup" aria-label="%2$s" data-select="%3$s">%4$s</div></div>',
		$html,
		esc_attr( wc_attribute_label( $attribute, $product ) ),
		esc_attr( $select_id ),
		$chips
	);
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'crea_legacy_variation_options', 10, 2 );

function crea_legacy_remove_link( $link, $cart_item_key ) {
	$item = WC()->cart->get_cart_item( $cart_item_key );

	if ( ! $item ) {
		return $link;
	}

	$product = $item['data'];

	return sprintf(
		'<a href="%1$s" class="remove remove--text" aria-label="%2$s" data-product_id="%3$s" data-product_sku="%4$s" data-cart_item_key="%5$s">%6$s</a>',
		esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
		esc_attr( sprintf( __( 'Retirer %s du panier', 'crea-legacy' ), wp_strip_all_tags( $product->get_name() ) ) ),
		esc_attr( $item['product_id'] ),
		esc_attr( $product->get_sku() ),
		esc_attr( $cart_item_key ),
		esc_html__( 'Retirer du panier', 'crea-legacy' )
	);
}
add_filter( 'woocommerce_cart_item_remove_link', 'crea_legacy_remove_link', 10, 2 );

function crea_legacy_received_order() {
	$order = wc_get_order( absint( get_query_var( 'order-received' ) ) );
	$key   = isset( $_GET['key'] ) ? wc_clean( wp_unslash( $_GET['key'] ) ) : '';

	if ( ! $order || ! $key || ! hash_equals( $order->get_order_key(), $key ) ) {
		return null;
	}

	return $order;
}

function crea_legacy_order_received_title( $title, $id = 0 ) {
	if ( is_admin() || ! is_order_received_page() || ! in_the_loop() || (int) $id !== wc_get_page_id( 'checkout' ) ) {
		return $title;
	}

	$order = crea_legacy_received_order();

	if ( ! $order || ! $order->get_billing_first_name() ) {
		return $title;
	}

	return sprintf( __( 'Merci %s !', 'crea-legacy' ), esc_html( $order->get_billing_first_name() ) );
}
add_filter( 'the_title', 'crea_legacy_order_received_title', 20, 2 );

function crea_legacy_order_received_text( $text, $order ) {
	if ( ! $order ) {
		return $text;
	}

	return sprintf(
		__( 'Ta commande n° %s est validée. Un e-mail de confirmation vient de partir.', 'crea-legacy' ),
		esc_html( $order->get_order_number() )
	);
}
add_filter( 'woocommerce_thankyou_order_received_text', 'crea_legacy_order_received_text', 10, 2 );

function crea_legacy_order_tracking( $order_id ) {
	$order = wc_get_order( $order_id );

	if ( $order ) {
		get_template_part( 'template-parts/order/tracking', null, array( 'order' => $order ) );
	}
}

function crea_legacy_order_actions() {
	get_template_part( 'template-parts/order/actions' );
}

function crea_legacy_hidden_field( $field ) {
	if ( false === strpos( $field, 'type="hidden"' ) ) {
		return $field;
	}

	$field = preg_replace( '/\s(placeholder|readonly)="[^"]*"/', '', $field );

	return preg_replace( '/<label for="[^"]*"/', '<label', $field );
}
add_filter( 'woocommerce_form_field', 'crea_legacy_hidden_field' );

function crea_legacy_checkout_heading() {
	printf( '<h2 class="visually-hidden">%s</h2>', esc_html__( 'Tes informations', 'crea-legacy' ) );
}
add_action( 'woocommerce_checkout_before_customer_details', 'crea_legacy_checkout_heading' );
