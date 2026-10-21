<?php

function crea_legacy_antispam_token() {
	$time = time();

	return $time . '.' . wp_hash( 'crea-antispam|' . $time, 'nonce' );
}

function crea_legacy_antispam_fields() {
	printf(
		'<div class="hp-field" aria-hidden="true"><label for="crea-site">%1$s</label><input type="text" id="crea-site" name="crea_site" value="" tabindex="-1" autocomplete="off"></div><input type="hidden" name="crea_token" value="%2$s">',
		esc_html__( 'Ne remplis pas ce champ', 'crea-legacy' ),
		esc_attr( crea_legacy_antispam_token() )
	);
}
add_action( 'woocommerce_register_form', 'crea_legacy_antispam_fields' );
add_action( 'comment_form_logged_in_after', 'crea_legacy_antispam_fields' );
add_action( 'comment_form_after_fields', 'crea_legacy_antispam_fields' );

function crea_legacy_antispam_is_bot() {
	$honeypot = isset( $_POST['crea_site'] ) ? trim( wp_unslash( $_POST['crea_site'] ) ) : '';
	$token    = isset( $_POST['crea_token'] ) ? sanitize_text_field( wp_unslash( $_POST['crea_token'] ) ) : '';
	$parts    = explode( '.', $token );

	if ( '' !== $honeypot || 2 !== count( $parts ) ) {
		return true;
	}

	$time = (int) $parts[0];

	if ( ! hash_equals( wp_hash( 'crea-antispam|' . $time, 'nonce' ), $parts[1] ) ) {
		return true;
	}

	$age = time() - $time;

	return $age < 3 || $age > DAY_IN_SECONDS;
}

function crea_legacy_antispam_registration( $errors ) {
	if ( ! isset( $_POST['register'] ) ) {
		return $errors;
	}

	if ( crea_legacy_antispam_is_bot() ) {
		$errors->add( 'crea_spam', __( 'Ton inscription n’a pas pu être validée. Patiente quelques secondes puis réessaie.', 'crea-legacy' ) );
	}

	return $errors;
}
add_filter( 'woocommerce_process_registration_errors', 'crea_legacy_antispam_registration' );

function crea_legacy_antispam_comment( $data ) {
	if ( 'product' === get_post_type( $data['comment_post_ID'] ?? 0 ) && ! is_admin() && crea_legacy_antispam_is_bot() ) {
		wp_die(
			esc_html__( 'Ton avis n’a pas pu être envoyé. Reviens en arrière, patiente quelques secondes puis réessaie.', 'crea-legacy' ),
			esc_html__( 'Avis non envoyé', 'crea-legacy' ),
			array(
				'response'  => 403,
				'back_link' => true,
			)
		);
	}

	return $data;
}
add_filter( 'preprocess_comment', 'crea_legacy_antispam_comment' );
