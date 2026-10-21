<?php

function crea_legacy_coupon_label( $label, $coupon ) {
	return sprintf( __( 'Code promo : %s', 'crea-legacy' ), esc_html( strtoupper( $coupon->get_code() ) ) );
}
add_filter( 'woocommerce_cart_totals_coupon_label', 'crea_legacy_coupon_label', 10, 2 );

function crea_legacy_coupon_message( $message, $code, $coupon ) {
	if ( WC_Coupon::WC_COUPON_SUCCESS === $code ) {
		$description = $coupon->get_description();

		return $description
			? sprintf( __( 'Code %1$s appliqué : %2$s', 'crea-legacy' ), strtoupper( $coupon->get_code() ), $description )
			: __( 'Code appliqué, profite bien !', 'crea-legacy' );
	}

	if ( WC_Coupon::WC_COUPON_REMOVED === $code ) {
		return __( 'Code retiré de ton panier.', 'crea-legacy' );
	}

	return $message;
}
add_filter( 'woocommerce_coupon_message', 'crea_legacy_coupon_message', 10, 3 );
