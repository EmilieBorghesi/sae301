<?php

require_once get_stylesheet_directory() . '/inc/helpers.php';
require_once get_stylesheet_directory() . '/inc/setup.php';
require_once get_stylesheet_directory() . '/inc/assets.php';
require_once get_stylesheet_directory() . '/inc/storefront.php';

if ( class_exists( 'WooCommerce' ) ) {
	require_once get_stylesheet_directory() . '/inc/woocommerce.php';
	require_once get_stylesheet_directory() . '/inc/product-fields.php';
	require_once get_stylesheet_directory() . '/inc/pickup.php';
	require_once get_stylesheet_directory() . '/inc/account.php';
	require_once get_stylesheet_directory() . '/inc/emails.php';
}
