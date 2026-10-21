<?php
$crea_role  = crea_legacy_member_field( 'crea_role' );
$crea_level = in_array( $args['level'] ?? '', array( 'h2', 'h3' ), true ) ? $args['level'] : 'h2';
?>
<article class="member-card">
	<div class="member-card__media">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'woocommerce_thumbnail', array( 'class' => 'member-card__photo' ) ); ?>
		<?php else : ?>
			<span class="member-card__initial" aria-hidden="true"><?php echo esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></span>
		<?php endif; ?>
	</div>
	<<?php echo esc_html( $crea_level ); ?> class="member-card__name"><a class="member-card__link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo esc_html( $crea_level ); ?>>
	<?php if ( $crea_role ) : ?>
		<p class="member-card__role"><?php echo esc_html( $crea_role ); ?></p>
	<?php endif; ?>
</article>
