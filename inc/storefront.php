<?php

function crea_legacy_storefront_cleanup() {
	remove_action( 'storefront_before_content', 'woocommerce_breadcrumb', 10 );
	remove_action( 'storefront_sidebar', 'storefront_get_sidebar', 10 );
	remove_action( 'storefront_after_footer', 'storefront_sticky_single_add_to_cart', 999 );
	remove_action( 'woocommerce_after_single_product_summary', 'storefront_single_product_pagination', 30 );
}
add_action( 'init', 'crea_legacy_storefront_cleanup' );
