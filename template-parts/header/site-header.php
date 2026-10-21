<?php
$crea_has_wc      = function_exists( 'WC' );
$crea_cart_url    = $crea_has_wc ? wc_get_cart_url() : home_url( '/' );
$crea_account_url = $crea_has_wc ? wc_get_page_permalink( 'myaccount' ) : wp_login_url();
$crea_on_cart     = $crea_has_wc && ( is_cart() || is_checkout() );
$crea_on_account  = $crea_has_wc && is_account_page();
?>
<a class="skip-link" href="#content"><?php esc_html_e( 'Aller au contenu', 'crea-legacy' ); ?></a>
<header class="header" id="masthead">
	<a class="header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<?php echo crea_legacy_logo( 'header__logo-img' ); ?>
	</a>
	<button class="header__toggle" type="button" aria-controls="site-menu" aria-expanded="false">
		<?php echo crea_legacy_icon( 'menu', 'header__toggle-icon header__toggle-icon--open' ); ?>
		<?php echo crea_legacy_icon( 'close', 'header__toggle-icon header__toggle-icon--close' ); ?>
		<span class="visually-hidden"><?php esc_html_e( 'Menu', 'crea-legacy' ); ?></span>
	</button>
	<nav class="header__nav nav" id="site-menu" aria-label="<?php esc_attr_e( 'Menu principal', 'crea-legacy' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'nav__list',
				'depth'          => 1,
				'fallback_cb'    => false,
			)
		);
		?>
	</nav>
	<div class="header__actions">
		<a class="icon-link<?php echo $crea_on_account ? ' icon-link--active' : ''; ?>" href="<?php echo esc_url( $crea_account_url ); ?>"<?php echo $crea_on_account ? ' aria-current="page"' : ''; ?>>
			<?php echo crea_legacy_icon( 'user', 'icon-link__svg' ); ?>
			<span class="visually-hidden"><?php esc_html_e( 'Mon compte', 'crea-legacy' ); ?></span>
		</a>
		<a class="icon-link<?php echo $crea_on_cart ? ' icon-link--active' : ''; ?>" href="<?php echo esc_url( $crea_cart_url ); ?>">
			<?php echo crea_legacy_icon( 'cart', 'icon-link__svg' ); ?>
			<span class="visually-hidden"><?php esc_html_e( 'Panier', 'crea-legacy' ); ?></span>
		</a>
	</div>
</header>
