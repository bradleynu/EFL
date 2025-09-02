<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

global $wp_query;

$order = wc_get_order( $wp_query->query['view-order'] );

if($order):
	$order_data = $order->get_data();
	$statuses = array(
		'processing' => 'Procesando',
	);
	$statuses_keys = array_keys($statuses);
	$statuses_keys[] = 'completed';

	if(  in_array( $order_data['status'], $statuses_keys)  ):
		foreach ($order_data['meta_data'] as $meta) {
			if($meta->key == 'delivery_date')
				$delivery_date = $meta->value;
		}
		function SpanishDate($FechaStamp){
		   $mes = date('n',$FechaStamp);
		   $dia = date('d',$FechaStamp);
		   $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
		             "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		   return "$dia de ". $mesesN[$mes];
		}
		if($delivery_date == NULL){
			$delivery_date = 'Entregado';
		}else{
			$delivery_date = DateTime::createFromFormat("Y-m-d", $delivery_date);
			$delivery_date = SpanishDate($delivery_date->getTimestamp());
		}

		?>
		<div class="hidden-xs">
		<h3>Seguimiento del producto</h3>
		<?php if($delivery_date != 'Entregado'): ?>
			<br>
			<h4 class="text-success"><?php echo $order_data['status'] == 'completed' ? 'Entregado el ' : 'Lega el ' ?><?php echo $delivery_date; ?></h4>
		<?php endif; ?>
		<div id="order-timeline" class="<?php echo $order_data['status']; ?>" >
			<div class="line">
				<div class="time"></div>
				<span class="icon"></span>
			</div>
			<div class="statuses">
				<div class="recived"><p>Recibido</p></div>
				<?php foreach ($statuses as $key => $value): ?>
					<div class="<?php echo str_replace('wc-', '', $key); ?>"><p><?php echo $value; ?></p></div>
				<?php endforeach; ?>
				<div class="completed"><p><?php echo $delivery_date; ?></p></div>
			</div>
		</div>
		</div>
	<?php endif;
endif; ?>

<div class="row woocomerce-dashboard">
	<div class="col-sm-3">
		<?php
			/**
			 * My Account navigation.
			 * @since 2.6.0
			 */
			do_action( 'woocommerce_account_navigation' );
		?>
	</div>
	<div class="col-sm-9">
		<div class="woocommerce-MyAccount-content">
			<div class="tab-content">
				<?php
					/**
					 * My Account content.
					 * @since 2.6.0
					 */
					do_action( 'woocommerce_account_content' );
				?>
			</div>
		</div>
	</div>
</div>