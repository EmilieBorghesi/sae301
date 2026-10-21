<?php

function crea_legacy_latest_products() {
	return wc_get_products(
		array(
			'status'     => 'publish',
			'limit'      => 3,
			'visibility' => 'catalog',
			'orderby'    => 'date',
			'order'      => 'DESC',
		)
	);
}
