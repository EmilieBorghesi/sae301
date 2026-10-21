<p class="order-actions">
	<?php if ( is_user_logged_in() ) : ?>
		<a class="btn btn--small" href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>"><?php esc_html_e( 'Voir mes commandes', 'crea-legacy' ); ?></a>
	<?php endif; ?>
	<a class="btn btn--small btn--more" href="<?php echo esc_url( crea_legacy_click_collect_url() ); ?>"><?php esc_html_e( 'Retour à la carte', 'crea-legacy' ); ?><?php echo crea_legacy_icon( 'chevron-right', 'btn__icon' ); ?></a>
</p>
