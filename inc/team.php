<?php

function crea_legacy_team_query( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_post_type_archive( 'crea_member' ) ) {
		$query->set( 'orderby', array( 'menu_order' => 'ASC', 'title' => 'ASC' ) );
		$query->set( 'posts_per_page', -1 );
	}
}
add_action( 'pre_get_posts', 'crea_legacy_team_query' );

function crea_legacy_member_field( $name, $id = null ) {
	return function_exists( 'get_field' ) ? get_field( $name, $id ? $id : get_the_ID() ) : '';
}
