<?php
/**
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email );
?>
<div class="email-introduction">
	<p><?php echo esc_html( $order->get_billing_first_name() ? sprintf( __( 'Coucou %s,', 'crea-legacy' ), $order->get_billing_first_name() ) : __( 'Coucou,', 'crea-legacy' ) ); ?></p>
	<p><?php esc_html_e( 'Bonne nouvelle : ta commande est prête. Tu peux venir la récupérer au comptoir.', 'crea-legacy' ); ?></p>
	<?php if ( 'cod' === $order->get_payment_method() && ! $order->get_date_paid() ) : ?>
		<p><?php echo wp_kses_post( sprintf( __( 'Pense à prévoir %s : tu régleras sur place.', 'crea-legacy' ), $order->get_formatted_order_total() ) ); ?></p>
	<?php endif; ?>
</div>
<?php
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

if ( $additional_content ) {
	echo '<table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation"><tr><td class="email-additional-content">' . wp_kses_post( wpautop( wptexturize( $additional_content ) ) ) . '</td></tr></table>';
}

do_action( 'woocommerce_email_footer', $email );
