<?php
$crea_categories = crea_legacy_product_categories();

if ( ! $crea_categories || ! shortcode_exists( 'products' ) ) {
	return;
}
?>
<nav class="cnc__filters" aria-label="<?php esc_attr_e( 'Catégories', 'crea-legacy' ); ?>">
	<ul class="chips">
		<?php foreach ( $crea_categories as $crea_category ) : ?>
			<li><a class="chip" href="#categorie-<?php echo esc_attr( $crea_category->slug ); ?>"><?php echo esc_html( $crea_category->name ); ?></a></li>
		<?php endforeach; ?>
	</ul>
</nav>
<?php foreach ( $crea_categories as $crea_category ) : ?>
	<section class="cnc__category" id="categorie-<?php echo esc_attr( $crea_category->slug ); ?>" aria-labelledby="titre-<?php echo esc_attr( $crea_category->slug ); ?>">
		<h2 class="title title--h2 cnc__title" id="titre-<?php echo esc_attr( $crea_category->slug ); ?>"><?php echo esc_html( $crea_category->name ); ?></h2>
		<?php echo do_shortcode( sprintf( '[products category="%s" columns="3" limit="-1" orderby="menu_order" order="ASC"]', esc_attr( $crea_category->slug ) ) ); ?>
	</section>
<?php endforeach; ?>
