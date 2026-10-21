<?php

function crea_legacy_register_order_status() {
	register_post_status(
		'wc-ready-pickup',
		array(
			'label'                     => _x( 'Prête à retirer', 'Order status', 'crea-legacy' ),
			'public'                    => false,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Prête à retirer <span class="count">(%s)</span>', 'Prêtes à retirer <span class="count">(%s)</span>', 'crea-legacy' ),
		)
	);
}
add_action( 'init', 'crea_legacy_register_order_status' );

function crea_legacy_order_statuses( $statuses ) {
	$ordered = array();

	foreach ( $statuses as $key => $label ) {
		$ordered[ $key ] = $label;

		if ( 'wc-processing' === $key ) {
			$ordered['wc-ready-pickup'] = _x( 'Prête à retirer', 'Order status', 'crea-legacy' );
		}
	}

	return $ordered;
}
add_filter( 'wc_order_statuses', 'crea_legacy_order_statuses' );

function crea_legacy_paid_statuses( $statuses ) {
	$statuses[] = 'ready-pickup';

	return $statuses;
}
add_filter( 'woocommerce_order_is_paid_statuses', 'crea_legacy_paid_statuses' );

function crea_legacy_editable_statuses( $statuses ) {
	return array_diff( $statuses, array( 'ready-pickup' ) );
}
add_filter( 'wc_order_is_editable_statuses', 'crea_legacy_editable_statuses' );

function crea_legacy_ready_actions( $actions ) {
	$actions['mark_ready-pickup'] = __( 'Passer en « Prête à retirer »', 'crea-legacy' );

	return $actions;
}
add_filter( 'bulk_actions-edit-shop_order', 'crea_legacy_ready_actions' );
add_filter( 'bulk_actions-woocommerce_page_wc-orders', 'crea_legacy_ready_actions' );

function crea_legacy_ready_email_class( $emails ) {
	require_once get_stylesheet_directory() . '/inc/class-crea-legacy-email-ready-pickup.php';
	$emails['Crea_Legacy_Email_Ready_Pickup'] = new Crea_Legacy_Email_Ready_Pickup();

	return $emails;
}
add_filter( 'woocommerce_email_classes', 'crea_legacy_ready_email_class' );

function crea_legacy_ready_email_action( $actions ) {
	$actions[] = 'woocommerce_order_status_ready-pickup';

	return $actions;
}
add_filter( 'woocommerce_email_actions', 'crea_legacy_ready_email_action' );

function crea_legacy_view_order_tracking( $order_id ) {
	crea_legacy_order_tracking( $order_id );
}
add_action( 'woocommerce_view_order', 'crea_legacy_view_order_tracking', 5 );
