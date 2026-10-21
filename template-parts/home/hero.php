<?php
$crea_video = crea_legacy_mod( 'hero_video' );
$crea_image = absint( crea_legacy_mod( 'hero_image' ) );
$crea_embed = $crea_video ? wp_oembed_get( $crea_video ) : '';

if ( ! $crea_embed && ! $crea_image ) {
	return;
}
?>
<section class="hero" aria-label="<?php esc_attr_e( 'À la une', 'crea-legacy' ); ?>">
	<div class="hero__inner">
		<?php if ( $crea_embed ) : ?>
			<div class="hero__video"><?php echo crea_legacy_oembed( $crea_embed ); ?></div>
		<?php endif; ?>
		<?php if ( $crea_image ) : ?>
			<?php
			echo wp_get_attachment_image(
				$crea_image,
				'large',
				false,
				array(
					'class'   => 'hero__image',
					'loading' => 'eager',
				)
			);
			?>
		<?php endif; ?>
	</div>
</section>
