<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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
 * @version 3.0.3
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action('_woocommerce_before_cart'); ?>

<div class="row">
	<div class="col-md-8">

		<form action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

			<?php do_action('woocommerce_before_cart_table'); ?>

			<div class="cart-list">

				<div class="cart-title">
					<div class="row">
						<div class="col-sm-6 col-xs-12">
							<h3>
								<?php echo pll_e('Carrito de compra', 'efl'); ?>
							</h3>
							<br class="visible-xs">
						</div>
						<div class="col-xs-offset-4 col-sm-3 col-xs-4 text-center">
							<p>
								<?php echo pll_e('Precio', 'efl'); ?>
							</p>
						</div>
						<div class="col-sm-3 col-xs-4 text-right">
							<p>
								<?php echo pll_e('Cantidad', 'efl'); ?>
							</p>
						</div>
					</div>
				</div>

				<?php do_action('woocommerce_before_cart_contents'); ?>

				<?php
				foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
					$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
					$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

					if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
						$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
						?>
						<div
							class="cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
							<div class="row">
								<div class="col-sm-6 col-xs-4 product-column">
									<div class="row">
										<div class="col-sm-5">
											<div class="thumbnail">
												<?php
												$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

												if (!$product_permalink) {
													echo $thumbnail;
												} else {
													printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
												}
												?>
											</div>
										</div>
										<div class="col-sm-7">

											<h5>
												<?php echo apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key) . '&nbsp;'; ?>
											</h5>

											<?php
											// Meta data
											echo WC()->cart->get_item_data($cart_item);

											// Backorder notification
											if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
												echo '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>';
											}
											?>

											<div class="links">
												<?php
												echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
													'<a href="%s" title="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
													esc_url(WC()->cart->get_remove_url($cart_item_key)),
													__('Remove this item', 'woocommerce'),
													esc_attr($product_id),
													esc_attr($_product->get_sku()),
													esc_html__('Eliminar', 'lanco')
												), $cart_item_key);
												?>
											</div>

										</div>
									</div>
								</div>
								<div class="col-sm-3 col-xs-4 price-column text-center">
									<p class="price">
										<?php
										echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
										?>
									</p>
								</div>
								<div class="col-sm-3 col-xs-4 text-right">
									<?php
									if ($_product->is_sold_individually()) {
										$product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
									} else {
										$product_quantity = woocommerce_quantity_input(array(
											'input_name' => "cart[{$cart_item_key}][qty]",
											'input_value' => $cart_item['quantity'],
											'max_value' => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
											'min_value' => '0'
										), $_product, false);
									}

									echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
									?>
									<?php
									// echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
									?>
								</div>
							</div>
						</div>
						<?php
					}
				}

				do_action('woocommerce_cart_contents');
				?>
				<br />
				<div class="actions row">
					<div class="col-sm-9">

						<?php if (wc_coupons_enabled()) { ?>
							<div class="coupon form-inline">
								<div class="form-group">
									<label for="coupon_code">
										<?php _e('Coupon:', 'woocommerce'); ?>
									</label>
									<input type="text" name="coupon_code" class="input-text form-control" id="coupon_code"
										value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
								</div>
								<button type="submit" class="btn btn-lg btn-primary" name="apply_coupon"
									value="<?php esc_attr_e('Aplicar Cupón', 'woocommerce'); ?>">
									<?php pll_e('Aplicar Cupón', 'woocommerce'); ?>
								</button>

								<?php do_action('woocommerce_cart_coupon'); ?>
							</div>
						<?php } ?>

					</div>

					<div class="col-sm-3 text-right">

						<button type="submit" class="btn btn-lg btn-primary" name="update_cart"
							value="<?php esc_attr_e('Guardar', 'woocommerce'); ?>">
							<?php pll_e('Guardar', 'woocommerce'); ?>
						</button>

						<?php do_action('woocommerce_cart_actions'); ?>

					</div>

				</div>

				<?php do_action('woocommerce_after_cart_contents'); ?>

			</div>

			<?php do_action('woocommerce_after_cart_table'); ?>

			<?php wp_nonce_field('woocommerce-cart'); ?>

		</form>

	</div>

	<div class="col-md-4">
		<div class="sidebar">
			<div class="cart-collaterals">

				<?php do_action('woocommerce_cart_collaterals'); ?>

			</div>
		</div>
	</div>
</div>



<?php do_action('_woocommerce_after_cart'); ?>