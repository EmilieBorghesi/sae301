<?php
get_header();
?>
<main class="team" id="main">
	<header class="page-head">
		<h1 class="title page-head__title"><?php esc_html_e( 'L’équipe', 'crea-legacy' ); ?></h1>
		<p class="page-head__text"><?php esc_html_e( 'Les cool kids qui préparent tes cookies, bagels et lattes chaque jour.', 'crea-legacy' ); ?></p>
	</header>
	<?php if ( have_posts() ) : ?>
		<ul class="team__grid">
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<li class="team__item">
					<?php get_template_part( 'template-parts/team/card' ); ?>
				</li>
			<?php endwhile; ?>
		</ul>
	<?php else : ?>
		<p class="team__empty"><?php esc_html_e( 'L’équipe arrive bientôt.', 'crea-legacy' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
