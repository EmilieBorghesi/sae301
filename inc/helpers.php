<?php

function crea_legacy_defaults() {
	return array(
		'menu_text'       => __( 'Click & Collect disponible !', 'crea-legacy' ),
		'franchise_title' => __( 'Deviens franchisé du plus cool des coffee shops', 'crea-legacy' ),
		'franchise_label' => __( 'Ouvre une franchise', 'crea-legacy' ),
	);
}

function crea_legacy_mod_source( $key ) {
	$front = (int) get_option( 'page_on_front' );
	$site  = array( 'click_collect_page', 'access_url', 'facebook_url', 'instagram_url' );

	return in_array( $key, $site, true ) || ! $front ? 'option' : $front;
}

function crea_legacy_mod( $key ) {
	$defaults = crea_legacy_defaults();
	$value    = function_exists( 'get_field' ) ? get_field( 'crea_' . $key, crea_legacy_mod_source( $key ) ) : null;

	return null === $value ? ( $defaults[ $key ] ?? '' ) : $value;
}

function crea_legacy_asset( $path ) {
	return get_stylesheet_directory_uri() . '/assets/' . ltrim( $path, '/' );
}

function crea_legacy_icon( $name, $class = '' ) {
	return sprintf(
		'<svg class="%1$s" aria-hidden="true" focusable="false"><use href="%2$s"></use></svg>',
		esc_attr( $class ),
		esc_url( crea_legacy_asset( 'images/sprite.svg' ) . '#' . $name )
	);
}

function crea_legacy_logo( $class ) {
	return sprintf(
		'<img class="%1$s" src="%2$s" width="666" height="202" alt="%3$s">',
		esc_attr( $class ),
		esc_url( crea_legacy_asset( 'images/logo.webp' ) ),
		esc_attr( get_bloginfo( 'name' ) )
	);
}

function crea_legacy_product_categories() {
	if ( ! taxonomy_exists( 'product_cat' ) ) {
		return array();
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'parent'     => 0,
			'hide_empty' => true,
			'orderby'    => 'menu_order',
			'exclude'    => array( (int) get_option( 'default_product_cat' ) ),
		)
	);

	return is_wp_error( $terms ) ? array() : $terms;
}

function crea_legacy_click_collect_url() {
	$page_id = absint( crea_legacy_mod( 'click_collect_page' ) );

	if ( ! $page_id ) {
		$pages = get_pages(
			array(
				'meta_key'   => '_wp_page_template',
				'meta_value' => 'template-click-collect.php',
				'number'     => 1,
			)
		);
		$page_id = $pages ? $pages[0]->ID : 0;
	}

	if ( $page_id ) {
		return get_permalink( $page_id );
	}

	return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
}
