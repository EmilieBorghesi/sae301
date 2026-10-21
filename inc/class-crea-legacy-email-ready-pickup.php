<?php

class Crea_Legacy_Email_Ready_Pickup extends WC_Email {

	public function __construct() {
		$this->id             = 'crea_ready_pickup';
		$this->customer_email = true;
		$this->title          = __( 'Commande prête à retirer', 'crea-legacy' );
		$this->description    = __( 'Envoyé au client quand sa commande passe au statut « Prête à retirer ».', 'crea-legacy' );
		$this->template_base  = get_stylesheet_directory() . '/woocommerce/';
		$this->template_html  = 'emails/customer-ready-pickup.php';
		$this->template_plain = 'emails/plain/customer-ready-pickup.php';
		$this->placeholders   = array(
			'{order_date}'   => '',
			'{order_number}' => '',
		);

		add_action( 'woocommerce_order_status_ready-pickup_notification', array( $this, 'trigger' ), 10, 2 );

		parent::__construct();
	}

	public function get_default_subject() {
		return __( 'Ta commande {site_title} n° {order_number} est prête !', 'crea-legacy' );
	}

	public function get_default_heading() {
		return __( 'Ta commande t’attend', 'crea-legacy' );
	}

	public function get_default_additional_content() {
		return __( 'À tout de suite au coffee shop !', 'crea-legacy' );
	}

	public function trigger( $order_id, $order = false ) {
		$this->setup_locale();

		if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
			$order = wc_get_order( $order_id );
		}

		if ( is_a( $order, 'WC_Order' ) ) {
			$this->object                         = $order;
			$this->recipient                      = $order->get_billing_email();
			$this->placeholders['{order_date}']   = wc_format_datetime( $order->get_date_created() );
			$this->placeholders['{order_number}'] = $order->get_order_number();
		}

		if ( $this->is_enabled() && $this->get_recipient() ) {
			$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
		}

		$this->restore_locale();
	}

	public function get_content_html() {
		return wc_get_template_html(
			$this->template_html,
			array(
				'order'              => $this->object,
				'email_heading'      => $this->get_heading(),
				'additional_content' => $this->get_additional_content(),
				'sent_to_admin'      => false,
				'plain_text'         => false,
				'email'              => $this,
			),
			'',
			$this->template_base
		);
	}

	public function get_content_plain() {
		return wc_get_template_html(
			$this->template_plain,
			array(
				'order'              => $this->object,
				'email_heading'      => $this->get_heading(),
				'additional_content' => $this->get_additional_content(),
				'sent_to_admin'      => false,
				'plain_text'         => true,
				'email'              => $this,
			),
			'',
			$this->template_base
		);
	}
}
