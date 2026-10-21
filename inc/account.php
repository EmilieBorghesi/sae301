<?php

function crea_legacy_account_menu( $items ) {
	$labels = array(
		'dashboard'       => __( 'Mon espace', 'crea-legacy' ),
		'orders'          => __( 'Mes commandes', 'crea-legacy' ),
		'edit-address'    => __( 'Mes adresses', 'crea-legacy' ),
		'edit-account'    => __( 'Mon profil', 'crea-legacy' ),
		'customer-logout' => __( 'Me déconnecter', 'crea-legacy' ),
	);

	unset( $items['downloads'], $items['payment-methods'] );

	foreach ( $labels as $key => $label ) {
		if ( isset( $items[ $key ] ) ) {
			$items[ $key ] = $label;
		}
	}

	return $items;
}
add_filter( 'woocommerce_account_menu_items', 'crea_legacy_account_menu', 20 );

function crea_legacy_account_dashboard() {
	$user = wp_get_current_user();

	printf(
		'<p class="account-hello">%1$s</p>',
		esc_html( sprintf( __( 'Coucou %s ! Retrouve ici tes commandes, leur suivi et tes infos.', 'crea-legacy' ), $user->first_name ? $user->first_name : $user->display_name ) )
	);

	printf(
		'<p class="account-actions"><a class="btn btn--small" href="%1$s">%2$s</a> <a class="btn btn--small btn--more" href="%3$s">%4$s%5$s</a></p>',
		esc_url( wc_get_account_endpoint_url( 'orders' ) ),
		esc_html__( 'Voir mes commandes', 'crea-legacy' ),
		esc_url( crea_legacy_click_collect_url() ),
		esc_html__( 'Commander', 'crea-legacy' ),
		crea_legacy_icon( 'chevron-right', 'btn__icon' )
	);
}
add_action( 'woocommerce_account_dashboard', 'crea_legacy_account_dashboard' );
