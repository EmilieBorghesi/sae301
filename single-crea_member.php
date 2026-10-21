<?php
get_header();
?>
<main class="member" id="main">
	<?php while ( have_posts() ) : ?>
		<?php
		the_post();
		$crea_role     = crea_legacy_member_field( 'crea_role' );
		$crea_shop     = crea_legacy_member_field( 'crea_shop' );
		$crea_since    = crea_legacy_member_field( 'crea_since' );
		$crea_quote    = crea_legacy_member_field( 'crea_quote' );
		$crea_favorite = function_exists( 'wc_get_product' ) ? wc_get_product( crea_legacy_member_field( 'crea_favorite' ) ) : null;
		?>
		<a class="back" href="<?php echo esc_url( get_post_type_archive_link( 'crea_member' ) ); ?>"><?php echo crea_legacy_icon( 'chevron-left', 'back__icon' ); ?><?php esc_html_e( 'Toute l’équipe', 'crea-legacy' ); ?></a>
		<article class="member__profile">
			<div class="member__media">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'large', array( 'class' => 'member__photo' ) ); ?>
				<?php else : ?>
					<span class="member__initial" aria-hidden="true"><?php echo esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></span>
				<?php endif; ?>
			</div>
			<div class="member__content">
				<h1 class="title member__name"><?php the_title(); ?></h1>
				<?php if ( $crea_role ) : ?>
					<p class="badge member__role"><?php echo esc_html( $crea_role ); ?></p>
				<?php endif; ?>
				<?php if ( $crea_quote ) : ?>
					<blockquote class="member__quote"><p><?php echo esc_html( $crea_quote ); ?></p></blockquote>
				<?php endif; ?>
				<div class="member__bio"><?php the_content(); ?></div>
				<dl class="infos member__infos">
					<?php if ( $crea_shop ) : ?>
						<div class="info-item">
							<dt class="info-item__term"><?php esc_html_e( 'Coffee shop', 'crea-legacy' ); ?></dt>
							<dd class="info-item__data"><?php echo esc_html( $crea_shop ); ?></dd>
						</div>
					<?php endif; ?>
					<?php if ( $crea_since ) : ?>
						<div class="info-item">
							<dt class="info-item__term"><?php esc_html_e( 'Dans l’équipe depuis', 'crea-legacy' ); ?></dt>
							<dd class="info-item__data"><?php echo esc_html( $crea_since ); ?></dd>
						</div>
					<?php endif; ?>
					<?php if ( $crea_favorite ) : ?>
						<div class="info-item">
							<dt class="info-item__term"><?php esc_html_e( 'Son produit préféré', 'crea-legacy' ); ?></dt>
							<dd class="info-item__data"><a class="member__link" href="<?php echo esc_url( $crea_favorite->get_permalink() ); ?>"><?php echo esc_html( $crea_favorite->get_name() ); ?></a></dd>
						</div>
					<?php endif; ?>
				</dl>
			</div>
		</article>
		<?php
		$crea_others = get_posts(
			array(
				'post_type'      => 'crea_member',
				'posts_per_page' => 3,
				'post__not_in'   => array( get_the_ID() ),
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
			)
		);
		?>
		<?php if ( $crea_others ) : ?>
			<section class="member__others" aria-labelledby="titre-autres">
				<h2 class="title title--h2" id="titre-autres"><?php esc_html_e( 'Le reste de la team', 'crea-legacy' ); ?></h2>
				<ul class="team__grid">
					<?php foreach ( $crea_others as $post ) : ?>
						<?php setup_postdata( $post ); ?>
						<li class="team__item"><?php get_template_part( 'template-parts/team/card', null, array( 'level' => 'h3' ) ); ?></li>
					<?php endforeach; ?>
					<?php wp_reset_postdata(); ?>
				</ul>
			</section>
		<?php endif; ?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
