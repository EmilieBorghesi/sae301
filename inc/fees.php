<?php

function crea_legacy_fee_missing( $cart ) {
	$amount    = (float) crea_legacy_cc_option( 'fee_amount' );
	$threshold = (float) crea_legacy_cc_option( 'fee_threshold' );
	$subtotal  = (float) $cart->get_subtotal() + (float) $cart->get_subtotal_tax();

	if ( $amount <= 0 || $subtotal <= 0 || $subtotal >= $threshold ) {
		return 0;
	}

	return $threshold - $subtotal;
}

function crea_legacy_preparation_fee( $cart ) {
	if ( is_admin() && ! wp_doing_ajax() ) {
		return;
	}

	if ( crea_legacy_fee_missing( $cart ) > 0 ) {
		$cart->add_fee( crea_legacy_cc_option( 'fee_label' ), (float) crea_legacy_cc_option( 'fee_amount' ) );
	}
}
add_action( 'woocommerce_cart_calculate_fees', 'crea_legacy_preparation_fee' );

function crea_legacy_fee_notice() {
	if ( ! WC()->cart || WC()->cart->is_empty() ) {
		return;
	}

	$missing = crea_legacy_fee_missing( WC()->cart );

	if ( $missing <= 0 ) {
		return;
	}

	printf(
		'<p class="fee-hint">%s</p>',
		wp_kses_post(
			sprintf(
				__( 'Plus que %1$s pour ne pas payer les %2$s.', 'crea-legacy' ),
				wc_price( $missing ),
				esc_html( mb_strtolower( crea_legacy_cc_option( 'fee_label' ) ) )
			)
		)
	);
}
add_action( 'woocommerce_before_cart_totals', 'crea_legacy_fee_notice' );
