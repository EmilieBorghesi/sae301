<?php

function crea_legacy_nutrition_rows( $id ) {
	$group  = get_field_object( 'field_crea_nutrition', $id );
	$values = (array) ( $group['value'] ?? array() );
	$rows   = array();

	foreach ( $group['sub_fields'] ?? array() as $field ) {
		$value = $values[ $field['name'] ] ?? '';

		if ( '' === $value || null === $value ) {
			continue;
		}

		$rows[] = array(
			'label' => $field['label'],
			'value' => trim( wc_format_localized_decimal( $value ) . ' ' . ( $field['append'] ?? '' ) ),
		);
	}

	return $rows;
}

function crea_legacy_product_infos() {
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}

	$id          = get_the_ID();
	$composition = get_field( 'crea_composition', $id );
	$allergens   = get_field( 'crea_allergens', $id );
	$nutrition   = crea_legacy_nutrition_rows( $id );

	if ( ! $composition && ! $allergens && ! $nutrition ) {
		return;
	}

	get_template_part(
		'template-parts/product/infos',
		null,
		array(
			'composition' => $composition,
			'allergens'   => $allergens ? wp_list_pluck( $allergens, 'label' ) : array(),
			'nutrition'   => $nutrition,
		)
	);
}
add_action( 'woocommerce_single_product_summary', 'crea_legacy_product_infos', 22 );
