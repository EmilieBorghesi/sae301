<?php

function crea_legacy_email_styles( $css ) {
	$css .= '
		.crea-email-logo { padding: 32px 32px 24px; text-align: center; background-color: #000000; }
		.crea-email-logo img { display: inline-block; max-width: 222px; height: auto; border: 0; }
		#template_header { background-color: #000000 !important; }
		#template_header h1 { padding: 0 32px 32px; font-family: "Arial Black", Arial, sans-serif; font-size: 28px; font-weight: 900; letter-spacing: 0.09em; line-height: 120%; text-align: center; text-transform: uppercase; color: #F39D9D !important; }
		#body_content_inner { color: #000000; }
		#body_content_inner h2 { font-family: "Arial Black", Arial, sans-serif; letter-spacing: 0.05em; text-transform: uppercase; color: #000000; }
		#body_content_inner a { color: #CC3366; }
		.email-pickup { margin: 0 0 24px; padding: 16px 20px; color: #000000; background-color: #F9D6D6; border-left: 4px solid #000000; }
		.email-pickup h2 { margin: 0 0 8px; font-size: 16px; }
		.email-pickup p { margin: 0 0 8px; }
		#template_footer #credit { color: #FFFFFF; background-color: #2D2850; }
		#template_footer #credit p { color: #FFFFFF; }
		#template_footer #credit a { font-weight: 700; color: #F39D9D; }
		.crea-email-socials a { margin: 0 8px; }
	';

	return $css;
}
add_filter( 'woocommerce_email_styles', 'crea_legacy_email_styles' );
