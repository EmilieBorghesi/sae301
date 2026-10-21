<?php
get_header();
?>
<main class="front" id="main">
	<h1 class="visually-hidden"><?php bloginfo( 'name' ); ?></h1>
	<?php get_template_part( 'template-parts/home/hero' ); ?>
	<?php get_template_part( 'template-parts/home/menu' ); ?>
	<?php get_template_part( 'template-parts/home/franchise' ); ?>
</main>
<?php
get_footer();
