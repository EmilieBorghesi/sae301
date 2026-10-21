<?php

function crea_legacy_review_form( $args ) {
	$args['title_reply']        = have_comments() ? __( 'Donne ton avis', 'crea-legacy' ) : sprintf( __( 'Sois le premier à donner ton avis sur « %s »', 'crea-legacy' ), get_the_title() );
	$args['title_reply_before'] = '<h3 id="reply-title" class="comment-reply-title">';
	$args['title_reply_after']  = '</h3>';
	$args['label_submit']       = __( 'Publier mon avis', 'crea-legacy' );

	return $args;
}
add_filter( 'woocommerce_product_review_comment_form_args', 'crea_legacy_review_form' );

function crea_legacy_reviews_tab( $tabs ) {
	if ( isset( $tabs['reviews'] ) ) {
		global $product;
		$tabs['reviews']['title'] = sprintf( __( 'Avis (%d)', 'crea-legacy' ), $product ? $product->get_review_count() : 0 );
	}

	if ( isset( $tabs['additional_information'] ) ) {
		$tabs['additional_information']['title'] = __( 'Options', 'crea-legacy' );
	}

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'crea_legacy_reviews_tab', 20 );
