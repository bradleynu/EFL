<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/success.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! $messages ){
	return;
}

?>

<?php foreach ( $messages as $message ) : ?>
	<?php if (!empty($_REQUEST['add-to-cart']) && strpos($message, 'added to your cart') !== false): ?>
	<div class="added-to-cart">
		<div class="bottom-padding">
			<div class="table reset border">
				<div class="cell v-middle">
					<div class="thumbnail reset">
						<?php echo get_the_post_thumbnail( $_REQUEST['add-to-cart'], 'thumbnail' ); ?>
					</div>
				</div>
				<div class="cell v-middle">
					<p class="success">
						<span class="ion-ios-checkmark"></span>
						<strong><?php echo esc_html__( 'Se agregó al carrito', 'lanco' ); ?></strong>
					</p>
				</div>
				<div class="cell v-middle">
					<p><?php printf('%s (%s)', esc_html__( 'Subtotal de la compra', 'lanco' ), sprintf(_n( '%s artículo', '%s artículos', WC()->cart->get_cart_contents_count(), 'lanco' ), WC()->cart->get_cart_contents_count() )) ?></p>
					<p><?php wc_cart_totals_subtotal_html() ?></p>
				</div>
				<div class="cell v-middle text-right">
					<a class="btn btn-default btn-lg" href="<?php echo get_permalink( wc_get_page_id( 'cart' ) ); ?>"><?php echo esc_html__( 'Carrito', 'lanco' ); ?></a>
					<a class="btn btn-success btn-lg" href="<?php echo get_permalink( wc_get_page_id( 'checkout' ) ); ?>"><?php echo esc_html__( 'Proceder a la compra', 'lanco' ); ?></a>
				</div>
			</div>
		</div>
	</div>
	<?php else: ?>
	<div class="woocommerce-message"><?php echo wp_kses_post( str_replace('Continue Shopping', 'Continuar Comprando', $message ) ); ?></div>
	<?php endif ?>
<?php endforeach; ?>
