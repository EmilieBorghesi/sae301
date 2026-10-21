<?php
/**
 * @version 10.7.0
 */

defined( 'ABSPATH' ) || exit;

$store_name = $store_name ?? get_bloginfo( 'name', 'display' );
$crea_logo  = get_stylesheet_directory_uri() . '/assets/images/logo-email.png';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<title><?php echo esc_html( $store_name ); ?></title>
	</head>
	<body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		<table width="100%" id="outer_wrapper" role="presentation">
			<tr>
				<td></td>
				<td width="600">
					<div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
						<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="inner_wrapper" role="presentation">
							<tr>
								<td align="center" valign="top">
									<table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
										<tr>
											<td id="template_header_image" class="crea-email-logo">
												<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank"><img src="<?php echo esc_url( $crea_logo ); ?>" width="222" height="68" alt="<?php echo esc_attr( $store_name ); ?>" /></a>
											</td>
										</tr>
									</table>
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_container" role="presentation">
										<tr>
											<td align="center" valign="top">
												<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header" role="presentation">
													<tr>
														<td id="header_wrapper">
															<h1><?php echo esc_html( $email_heading ); ?></h1>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_body" role="presentation">
													<tr>
														<td valign="top" id="body_content">
															<table border="0" cellpadding="20" cellspacing="0" width="100%" role="presentation">
																<tr>
																	<td valign="top" id="body_content_inner_cell">
																		<div id="body_content_inner">
