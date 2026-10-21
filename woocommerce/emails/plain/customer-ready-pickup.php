<?php
/**
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

echo "=================\n" . esc_html( wp_strip_all_tags( $email_heading ) ) . "\n=================\n\n";
echo esc_html( $order->get_billing_first_name() ? sprintf( __( 'Coucou %s,', 'crea-legacy' ), $order->get_billing_first_name() ) : __( 'Coucou,', 'crea-legacy' ) ) . "\n\n";
echo esc_html__( 'Bonne nouvelle : ta commande est prête. Tu peux venir la récupérer au comptoir.', 'crea-legacy' ) . "\n\n";

do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

if ( $additional_content ) {
	echo esc_html( wp_strip_all_tags( wptexturize( $additional_content ) ) ) . "\n\n";
}

echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
