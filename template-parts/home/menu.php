<?php
$crea_categories = crea_legacy_product_categories();
?>
<section class="menu-board" aria-labelledby="titre-carte">
	<div class="menu-board__head">
		<h2 class="title menu-board__title" id="titre-carte"><?php esc_html_e( 'La carte', 'crea-legacy' ); ?></h2>
		<?php if ( crea_legacy_mod( 'menu_text' ) ) : ?>
			<p class="subtitle"><?php echo esc_html( crea_legacy_mod( 'menu_text' ) ); ?></p>
		<?php endif; ?>
		<?php get_template_part( 'template-parts/shop/coffee-shops' ); ?>
	</div>
	<?php foreach ( $crea_categories as $crea_category ) : ?>
		<?php
		$crea_products = wc_get_products(
			array(
				'status'     => 'publish',
				'limit'      => 4,
				'category'   => array( $crea_category->slug ),
				'visibility' => 'catalog',
				'orderby'    => 'menu_order',
				'order'      => 'ASC',
			)
		);
		?>
		<section class="menu-board__category" aria-labelledby="carte-<?php echo esc_attr( $crea_category->slug ); ?>">
			<h3 class="title title--h3 menu-board__subtitle" id="carte-<?php echo esc_attr( $crea_category->slug ); ?>"><?php echo esc_html( $crea_category->name ); ?></h3>
			<?php if ( $crea_products ) : ?>
				<ul class="menu-board__grid">
					<?php foreach ( $crea_products as $crea_product ) : ?>
						<li class="menu-board__item">
							<a class="tile" href="<?php echo esc_url( $crea_product->get_permalink() ); ?>">
								<?php echo $crea_product->get_image( 'woocommerce_thumbnail', array( 'class' => 'tile__img' ) ); ?>
								<span class="visually-hidden"><?php echo esc_html( $crea_product->get_name() ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<a class="btn btn--small btn--cta-light" href="<?php echo esc_url( get_term_link( $crea_category ) ); ?>"><?php esc_html_e( 'Voir plus', 'crea-legacy' ); ?><span class="visually-hidden"> : <?php echo esc_html( $crea_category->name ); ?></span></a>
		</section>
	<?php endforeach; ?>
	<p class="menu-board__footer">
		<a class="btn btn--small btn--more btn--cta" href="<?php echo esc_url( crea_legacy_click_collect_url() ); ?>"><?php esc_html_e( 'Je commande', 'crea-legacy' ); ?><?php echo crea_legacy_icon( 'chevron-right', 'btn__icon' ); ?></a>
	</p>
</section>
