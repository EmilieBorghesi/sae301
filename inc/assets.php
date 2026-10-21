<?php

function crea_legacy_has_js() {
	wp_print_inline_script_tag( 'document.documentElement.classList.add("has-js");' );
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url( crea_legacy_asset( 'fonts/eighty-miles.woff2' ) )
	);
}
add_action( 'wp_head', 'crea_legacy_has_js', 1 );

function crea_legacy_assets() {
	$version = wp_get_theme()->get( 'Version' );

	wp_dequeue_style( 'storefront-fonts' );
	wp_dequeue_style( 'storefront-child-style' );

	$deps = array( 'storefront-style' );

	if ( wp_style_is( 'storefront-woocommerce-style', 'registered' ) ) {
		$deps[] = 'storefront-woocommerce-style';
	}

	foreach ( array( 'variables', 'base', 'components', 'layout', 'woocommerce' ) as $file ) {
		if ( 'woocommerce' === $file && ! class_exists( 'WooCommerce' ) ) {
			continue;
		}

		wp_enqueue_style( 'crea-legacy-' . $file, crea_legacy_asset( 'css/' . $file . '.css' ), $deps, $version );
		$deps = array( 'crea-legacy-' . $file );
	}

	wp_enqueue_script(
		'crea-legacy-menu',
		crea_legacy_asset( 'js/menu.js' ),
		array(),
		$version,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	if ( function_exists( 'is_product' ) && is_product() ) {
		wp_enqueue_script( 'crea-legacy-options', crea_legacy_asset( 'js/options.js' ), array( 'jquery' ), $version, true );
	}

	if ( function_exists( 'is_cart' ) && is_cart() ) {
		wp_enqueue_script( 'crea-legacy-cart', crea_legacy_asset( 'js/cart.js' ), array( 'jquery' ), $version, true );
	}
}
add_action( 'wp_enqueue_scripts', 'crea_legacy_assets', 40 );
