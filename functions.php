<?php

require_once get_stylesheet_directory() . '/inc/helpers.php';
require_once get_stylesheet_directory() . '/inc/setup.php';
require_once get_stylesheet_directory() . '/inc/assets.php';
require_once get_stylesheet_directory() . '/inc/storefront.php';
require_once get_stylesheet_directory() . '/inc/team.php';

if ( class_exists( 'WooCommerce' ) ) {
	require_once get_stylesheet_directory() . '/inc/woocommerce.php';
	require_once get_stylesheet_directory() . '/inc/product-fields.php';
	require_once get_stylesheet_directory() . '/inc/taxonomy.php';
	require_once get_stylesheet_directory() . '/inc/pickup.php';
	require_once get_stylesheet_directory() . '/inc/fees.php';
	require_once get_stylesheet_directory() . '/inc/account.php';
	require_once get_stylesheet_directory() . '/inc/promotions.php';
	require_once get_stylesheet_directory() . '/inc/reviews.php';
	require_once get_stylesheet_directory() . '/inc/orders.php';
	require_once get_stylesheet_directory() . '/inc/emails.php';
	require_once get_stylesheet_directory() . '/inc/home.php';
}
