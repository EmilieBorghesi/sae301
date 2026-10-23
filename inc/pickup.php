<?php

function crea_legacy_cc_option( $key ) {
	$defaults = array(
		'pickup_instructions' => __( "Présente-toi au comptoir avec ton numéro de commande.\nTa commande est prête 20 minutes après validation.\nTu as jusqu'à la fermeture pour la récupérer.", 'crea-legacy' ),
		'fee_label'           => __( 'Frais de préparation', 'crea-legacy' ),
		'fee_amount'          => '1.5',
		'fee_threshold'       => '25',
	);
	$value    = function_exists( 'get_field' ) ? get_field( 'crea_' . $key, 'option' ) : null;

	return null === $value ? ( $defaults[ $key ] ?? '' ) : $value;
}

function crea_legacy_is_pickup_method( $method_id ) {
	return 0 === strpos( (string) $method_id, 'local_pickup' ) || 0 === strpos( (string) $method_id, 'pickup_location' );
}

function crea_legacy_cart_is_pickup() {
	$chosen = WC()->session ? (array) WC()->session->get( 'chosen_shipping_methods', array() ) : array();

	foreach ( $chosen as $method ) {
		if ( crea_legacy_is_pickup_method( $method ) ) {
			return true;
		}
	}

	return false;
}

function crea_legacy_order_is_pickup( $order ) {
	foreach ( $order->get_shipping_methods() as $method ) {
		if ( crea_legacy_is_pickup_method( $method->get_method_id() ) ) {
			return true;
		}
	}

	return false;
}

function crea_legacy_pickup_box( $heading = 'h3' ) {
	$text = crea_legacy_cc_option( 'pickup_instructions' );

	if ( ! $text ) {
		return '';
	}

	return sprintf(
		'<div class="pickup"><%1$s class="pickup__title">%2$s</%1$s><div class="pickup__text">%3$s</div></div>',
		tag_escape( $heading ),
		esc_html__( 'Instructions pour le retrait', 'crea-legacy' ),
		wp_kses_post( wpautop( $text ) )
	);
}

function crea_legacy_checkout_pickup_html() {
	return '<div class="pickup-slot">' . ( crea_legacy_cart_is_pickup() ? crea_legacy_pickup_box() : '' ) . '</div>';
}

function crea_legacy_checkout_pickup() {
	echo crea_legacy_checkout_pickup_html();
}
add_action( 'woocommerce_review_order_before_payment', 'crea_legacy_checkout_pickup' );

function crea_legacy_checkout_pickup_fragment( $fragments ) {
	$fragments['.pickup-slot'] = crea_legacy_checkout_pickup_html();

	return $fragments;
}
add_filter( 'woocommerce_update_order_review_fragments', 'crea_legacy_checkout_pickup_fragment' );

function crea_legacy_thankyou_pickup( $order_id ) {
	$order = wc_get_order( $order_id );

	if ( $order && crea_legacy_order_is_pickup( $order ) ) {
		echo crea_legacy_pickup_box( 'h2' );
	}
}
add_action( 'woocommerce_thankyou', 'crea_legacy_thankyou_pickup', 10 );

function crea_legacy_email_pickup( $order, $sent_to_admin, $plain_text ) {
	if ( $sent_to_admin || ! crea_legacy_order_is_pickup( $order ) || in_array( $order->get_status(), array( 'cancelled', 'refunded', 'failed' ), true ) ) {
		return;
	}

	$text = crea_legacy_cc_option( 'pickup_instructions' );

	if ( ! $text ) {
		return;
	}

	if ( $plain_text ) {
		echo "\n" . esc_html( mb_strtoupper( __( 'Instructions pour le retrait', 'crea-legacy' ) ) ) . "\n\n" . esc_html( wp_strip_all_tags( $text ) ) . "\n\n";
		return;
	}

	printf(
		'<div class="email-pickup"><h2>%1$s</h2>%2$s</div>',
		esc_html__( 'Instructions pour le retrait', 'crea-legacy' ),
		wp_kses_post( wpautop( $text ) )
	);
}
add_action( 'woocommerce_email_before_order_table', 'crea_legacy_email_pickup', 20, 3 );
