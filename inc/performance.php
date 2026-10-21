<?php

function crea_legacy_trim_styles() {
	foreach ( array( 'wp-block-library', 'wp-block-library-theme', 'classic-theme-styles', 'global-styles', 'wc-blocks-style', 'storefront-gutenberg-blocks', 'storefront-woocommerce-brands-style', 'brands-styles' ) as $handle ) {
		wp_dequeue_style( $handle );
	}
}
add_action( 'wp_enqueue_scripts', 'crea_legacy_trim_styles', 100 );

function crea_legacy_no_migrate() {
	$scripts = wp_scripts();

	if ( isset( $scripts->registered['jquery'] ) ) {
		$scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
	}
}
add_action( 'wp_enqueue_scripts', 'crea_legacy_no_migrate', 1 );

function crea_legacy_scripts_in_footer() {
	$scripts = wp_scripts();

	foreach ( array_keys( $scripts->registered ) as $handle ) {
		$scripts->add_data( $handle, 'group', 1 );
	}
}
add_action( 'wp_enqueue_scripts', 'crea_legacy_scripts_in_footer', 200 );

function crea_legacy_gallery_support() {
	remove_theme_support( 'wc-product-gallery-zoom' );
	remove_theme_support( 'wc-product-gallery-lightbox' );
}
add_action( 'after_setup_theme', 'crea_legacy_gallery_support', 20 );

function crea_legacy_main_image_priority( $params ) {
	static $first = true;

	if ( $first ) {
		$params['fetchpriority'] = 'high';
		$params['loading']       = 'eager';
		$first                   = false;
	}

	return $params;
}
add_filter( 'woocommerce_gallery_image_html_attachment_image_params', 'crea_legacy_main_image_priority' );

function crea_legacy_webp_output( $formats ) {
	$formats['image/jpeg'] = 'image/webp';
	$formats['image/png']  = 'image/webp';

	return $formats;
}
add_filter( 'image_editor_output_format', 'crea_legacy_webp_output' );

function crea_legacy_meta_description() {
	$text = '';

	if ( is_front_page() ) {
		$text = get_bloginfo( 'description' );
	} elseif ( function_exists( 'is_product' ) && is_product() ) {
		$product = wc_get_product( get_queried_object_id() );
		$text    = $product ? $product->get_short_description() : '';
	} elseif ( is_tax() || is_category() || is_tag() ) {
		$text = term_description();
	} elseif ( is_post_type_archive( 'crea_member' ) ) {
		$text = __( 'Les cool kids qui préparent tes cookies, bagels et lattes chaque jour à Nice.', 'crea-legacy' );
	} elseif ( is_singular() ) {
		$post = get_queried_object();
		$text = has_excerpt( $post ) ? $post->post_excerpt : $post->post_content;
	}

	if ( function_exists( 'is_shop' ) && is_shop() ) {
		$text = __( 'Commande en ligne tes bagels, cookies et boissons chaudes et récupère-les en boutique à Nice.', 'crea-legacy' );
	}

	$text = trim( wp_trim_words( wp_strip_all_tags( strip_shortcodes( (string) $text ) ), 28, '…' ) );

	if ( '' === $text ) {
		$text = get_bloginfo( 'description' );
	}

	if ( $text ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $text ) );
	}
}
add_action( 'wp_head', 'crea_legacy_meta_description', 2 );

function crea_legacy_loop_button_label( $args, $product ) {
	if ( isset( $args['attributes']['aria-label'] ) ) {
		$args['attributes']['aria-label'] = sprintf( __( 'Ajouter au panier : %s', 'crea-legacy' ), wp_strip_all_tags( $product->get_name() ) );
	}

	return $args;
}
add_filter( 'woocommerce_loop_add_to_cart_args', 'crea_legacy_loop_button_label', 10, 2 );

function crea_legacy_async_icons( $tag, $handle ) {
	if ( 'storefront-icons' !== $handle ) {
		return $tag;
	}

	return str_replace( "media='all'", "media='print' onload=\"this.media='all'\"", $tag );
}
add_filter( 'style_loader_tag', 'crea_legacy_async_icons', 10, 2 );

function crea_legacy_variation_image( $data, $product, $variation ) {
	if ( ! $variation->get_image_id( 'edit' ) ) {
		$data['image'] = array();
	}

	return $data;
}
add_filter( 'woocommerce_available_variation', 'crea_legacy_variation_image', 10, 3 );
