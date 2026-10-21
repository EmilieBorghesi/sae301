<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php do_action( 'storefront_before_site' ); ?>
<div id="page" class="hfeed site">
	<?php do_action( 'storefront_before_header' ); ?>
	<?php get_template_part( 'template-parts/header/site-header' ); ?>
	<?php do_action( 'storefront_before_content' ); ?>
	<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">
			<?php do_action( 'storefront_content_top' ); ?>
