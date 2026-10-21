<?php
$crea_order = $args['order'] ?? null;

if ( ! $crea_order ) {
	return;
}

$crea_status  = $crea_order->get_status();
$crea_current = array(
	'pending'      => 1,
	'on-hold'      => 1,
	'processing'   => 2,
	'ready-pickup' => 3,
	'completed'    => 4,
);
$crea_step  = $crea_current[ $crea_status ] ?? 1;
$crea_steps = array(
	1 => __( 'Commande reçue', 'crea-legacy' ),
	2 => __( 'En préparation', 'crea-legacy' ),
	3 => __( 'Prête à retirer', 'crea-legacy' ),
);
$crea_infos = array_filter(
	array(
		__( 'Retrait', 'crea-legacy' ) => $crea_order->get_shipping_method(),
		__( 'Paiement', 'crea-legacy' ) => trim( $crea_order->get_payment_method_title() . ', ' . html_entity_decode( wp_strip_all_tags( wc_price( $crea_order->get_total(), array( 'currency' => $crea_order->get_currency() ) ) ), ENT_QUOTES, 'UTF-8' ), ', ' ),
	)
);
?>
<section class="tracking-card" aria-labelledby="titre-suivi">
	<div class="tracking-card__head">
		<h2 class="title title--h3 tracking-card__title" id="titre-suivi"><?php esc_html_e( 'Suivi de ta commande', 'crea-legacy' ); ?></h2>
		<span class="badge"><?php echo esc_html( wc_get_order_status_name( $crea_status ) ); ?></span>
	</div>
	<ol class="tracking">
		<?php foreach ( $crea_steps as $crea_number => $crea_label ) : ?>
			<?php
			$crea_state = '';

			if ( $crea_number < $crea_step ) {
				$crea_state = ' tracking-step--done';
			} elseif ( $crea_number === $crea_step ) {
				$crea_state = ' tracking-step--current';
			}
			?>
			<li class="tracking-step<?php echo esc_attr( $crea_state ); ?>"<?php echo $crea_number === $crea_step ? ' aria-current="step"' : ''; ?>>
				<span class="tracking-step__dot" aria-hidden="true"><?php echo esc_html( $crea_number ); ?></span>
				<span class="tracking-step__label"><?php echo esc_html( $crea_label ); ?></span>
			</li>
		<?php endforeach; ?>
	</ol>
	<?php if ( $crea_infos ) : ?>
		<dl class="infos tracking-card__infos">
			<?php foreach ( $crea_infos as $crea_term => $crea_data ) : ?>
				<div class="info-item">
					<dt class="info-item__term"><?php echo esc_html( $crea_term ); ?></dt>
					<dd class="info-item__data"><?php echo esc_html( $crea_data ); ?></dd>
				</div>
			<?php endforeach; ?>
		</dl>
	<?php endif; ?>
</section>
