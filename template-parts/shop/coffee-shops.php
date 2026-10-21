<?php
$crea_locations = get_nav_menu_locations();

if ( empty( $crea_locations['crea-coffee-shops'] ) || ! wp_get_nav_menu_items( $crea_locations['crea-coffee-shops'] ) ) {
	return;
}
?>
<details class="dropdown shops">
	<summary class="dropdown__toggle"><?php esc_html_e( 'Choisis ton coffee shop', 'crea-legacy' ); ?><?php echo crea_legacy_icon( 'chevron-down', 'dropdown__icon' ); ?></summary>
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'crea-coffee-shops',
			'container'      => false,
			'menu_class'     => 'dropdown__list',
			'depth'          => 1,
			'fallback_cb'    => false,
		)
	);
	?>
</details>
