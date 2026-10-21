<?php
/**
 * Template Name: Click & Collect
 */

get_header();
?>
<main class="cnc" id="main">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<header class="page-head">
			<h1 class="title page-head__title"><?php the_title(); ?></h1>
			<?php if ( get_the_content() ) : ?>
				<div class="page-head__text"><?php the_content(); ?></div>
			<?php endif; ?>
			<?php get_template_part( 'template-parts/shop/coffee-shops' ); ?>
		</header>
	<?php endwhile; ?>
	<?php get_template_part( 'template-parts/shop/categories' ); ?>
	<?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
		<p class="cnc__footer">
			<a class="btn btn--more btn--cta" href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php esc_html_e( 'Panier', 'crea-legacy' ); ?><?php echo crea_legacy_icon( 'chevron-right', 'btn__icon' ); ?></a>
		</p>
	<?php endif; ?>
</main>
<?php
get_footer();
