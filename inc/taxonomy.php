<?php

function crea_legacy_moment_links() {
	$terms = get_the_terms( get_the_ID(), 'crea_moment' );

	if ( ! $terms || is_wp_error( $terms ) ) {
		return;
	}

	$links = '';

	foreach ( $terms as $term ) {
		$links .= sprintf( '<li><a class="chip" href="%1$s">%2$s</a></li>', esc_url( get_term_link( $term ) ), esc_html( $term->name ) );
	}

	printf(
		'<div class="moments"><p class="moments__label">%1$s</p><ul class="chips moments__list">%2$s</ul></div>',
		esc_html__( 'Parfait pour', 'crea-legacy' ),
		$links
	);
}
add_action( 'woocommerce_single_product_summary', 'crea_legacy_moment_links', 45 );

function crea_legacy_moment_nav() {
	if ( ! is_shop() && ! is_tax( 'crea_moment' ) ) {
		return;
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'crea_moment',
			'hide_empty' => true,
		)
	);

	if ( ! $terms || is_wp_error( $terms ) ) {
		return;
	}

	$current = get_queried_object_id();
	$links   = '';

	foreach ( $terms as $term ) {
		$active = $term->term_id === $current;
		$links .= sprintf(
			'<li><a class="chip%1$s" href="%2$s"%3$s>%4$s</a></li>',
			$active ? ' chip--active' : '',
			esc_url( get_term_link( $term ) ),
			$active ? ' aria-current="page"' : '',
			esc_html( $term->name )
		);
	}

	printf( '<nav class="moments moments--nav" aria-label="%1$s"><ul class="chips">%2$s</ul></nav>', esc_attr__( 'Moments', 'crea-legacy' ), $links );
}
add_action( 'woocommerce_before_shop_loop', 'crea_legacy_moment_nav', 5 );
