<?php
$crea_title = crea_legacy_mod( 'franchise_title' );
$crea_text  = crea_legacy_mod( 'franchise_text' );
$crea_url   = crea_legacy_mod( 'franchise_url' );
$crea_image = absint( crea_legacy_mod( 'franchise_image' ) );

if ( ! $crea_title ) {
	return;
}
?>
<section class="franchise" aria-labelledby="titre-franchise">
	<div class="franchise__inner">
		<div class="franchise__content">
			<h2 class="title title--h3 title--light franchise__title" id="titre-franchise"><?php echo esc_html( $crea_title ); ?></h2>
			<?php if ( $crea_text ) : ?>
				<div class="franchise__text"><?php echo wp_kses_post( wpautop( $crea_text ) ); ?></div>
			<?php endif; ?>
			<?php if ( $crea_url ) : ?>
				<a class="btn btn--white btn--small franchise__btn" href="<?php echo esc_url( $crea_url ); ?>"><?php echo esc_html( crea_legacy_mod( 'franchise_label' ) ); ?></a>
			<?php endif; ?>
		</div>
		<?php if ( $crea_image ) : ?>
			<?php echo wp_get_attachment_image( $crea_image, 'large', false, array( 'class' => 'franchise__image' ) ); ?>
		<?php else : ?>
			<p class="franchise__lettering" aria-hidden="true"><?php esc_html_e( 'Devenir franchisé', 'crea-legacy' ); ?></p>
		<?php endif; ?>
	</div>
</section>
