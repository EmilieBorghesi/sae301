<?php

function crea_legacy_setup() {
	load_child_theme_textdomain( 'crea-legacy', get_stylesheet_directory() . '/languages' );

	register_nav_menus(
		array(
			'crea-footer-1'     => __( 'Pied de page, colonne 1', 'crea-legacy' ),
			'crea-footer-2'     => __( 'Pied de page, colonne 2', 'crea-legacy' ),
			'crea-coffee-shops' => __( 'Liste des coffee shops', 'crea-legacy' ),
		)
	);
}
add_action( 'after_setup_theme', 'crea_legacy_setup', 20 );

function crea_legacy_menu_classes() {
	return array(
		'primary'           => array( 'nav__item', 'nav__link' ),
		'crea-footer-1'     => array( 'footer-nav__item', 'footer-nav__link' ),
		'crea-footer-2'     => array( 'footer-nav__item', 'footer-nav__link' ),
		'crea-coffee-shops' => array( 'dropdown__item', 'dropdown-item' ),
	);
}

function crea_legacy_menu_item_class( $classes, $item, $args ) {
	$map = crea_legacy_menu_classes();

	if ( isset( $args->theme_location, $map[ $args->theme_location ] ) ) {
		$classes[] = $map[ $args->theme_location ][0];
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'crea_legacy_menu_item_class', 10, 3 );

function crea_legacy_menu_link_attributes( $atts, $item, $args ) {
	$map = crea_legacy_menu_classes();

	if ( isset( $args->theme_location, $map[ $args->theme_location ] ) ) {
		$atts['class'] = trim( ( $atts['class'] ?? '' ) . ' ' . $map[ $args->theme_location ][1] );
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'crea_legacy_menu_link_attributes', 10, 3 );

function crea_legacy_menu_cart_item( $items, $args ) {
	if ( 'primary' !== ( $args->theme_location ?? '' ) || ! function_exists( 'wc_get_cart_url' ) ) {
		return $items;
	}

	return $items . sprintf(
		'<li class="menu-item nav__item nav__item--handheld"><a class="nav__link" href="%1$s">%2$s</a></li>',
		esc_url( wc_get_cart_url() ),
		esc_html__( 'Panier', 'crea-legacy' )
	);
}
add_filter( 'wp_nav_menu_items', 'crea_legacy_menu_cart_item', 10, 2 );

function crea_legacy_body_class( $classes ) {
	$classes   = array_diff( $classes, array( 'right-sidebar', 'left-sidebar' ) );
	$classes[] = 'crea';
	$classes[] = 'storefront-full-width-content';

	if ( is_front_page() ) {
		$classes[] = 'crea--full';
	}

	return array_values( array_unique( $classes ) );
}
add_filter( 'body_class', 'crea_legacy_body_class', 99 );

function crea_legacy_oembed( $html ) {
	$html = preg_replace( '/\s(frameborder|scrolling|marginwidth|marginheight)="[^"]*"/i', '', $html );

	return str_replace( '<iframe ', '<iframe loading="lazy" ', $html );
}
add_filter( 'embed_oembed_html', 'crea_legacy_oembed' );
add_filter( 'oembed_result', 'crea_legacy_oembed' );
