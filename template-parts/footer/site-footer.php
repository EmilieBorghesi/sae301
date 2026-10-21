<?php
$crea_access = crea_legacy_mod( 'access_url' );
$crea_socials = array(
	'facebook'  => array( crea_legacy_mod( 'facebook_url' ), 'Facebook' ),
	'instagram' => array( crea_legacy_mod( 'instagram_url' ), 'Instagram' ),
);
?>
<footer class="footer" id="colophon">
	<div class="footer__main">
		<?php if ( has_nav_menu( 'crea-footer-1' ) || has_nav_menu( 'crea-footer-2' ) ) : ?>
			<nav class="footer__nav" aria-label="<?php esc_attr_e( 'Pied de page', 'crea-legacy' ); ?>">
				<?php
				foreach ( array( 'crea-footer-1', 'crea-footer-2' ) as $crea_location ) {
					wp_nav_menu(
						array(
							'theme_location' => $crea_location,
							'container'      => false,
							'menu_class'     => 'footer-nav',
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				}
				?>
			</nav>
		<?php endif; ?>
		<?php if ( $crea_access ) : ?>
			<a class="btn btn--white footer__cta" href="<?php echo esc_url( $crea_access ); ?>"><?php esc_html_e( 'Accès franchisé', 'crea-legacy' ); ?></a>
		<?php endif; ?>
	</div>
	<a class="footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php echo crea_legacy_logo( 'footer__logo-img' ); ?>
	</a>
	<?php if ( array_filter( wp_list_pluck( $crea_socials, 0 ) ) ) : ?>
		<ul class="footer__socials">
			<?php foreach ( $crea_socials as $crea_icon => $crea_social ) : ?>
				<?php if ( $crea_social[0] ) : ?>
					<li>
						<a class="social" href="<?php echo esc_url( $crea_social[0] ); ?>" rel="noopener">
							<?php echo crea_legacy_icon( $crea_icon, 'social__icon' ); ?>
							<span class="visually-hidden"><?php echo esc_html( $crea_social[1] ); ?></span>
						</a>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</footer>
