<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
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
 * @version     2.3.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="widget widget-cart-resume">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<h3><?php _e( 'Total', 'lanco' ); ?></h3>

	<div class="table">
		
		<div class="t-row">
			<div class="cell"><strong><?php _e( 'Subtotal', 'woocommerce' ); ?></strong></div>
			<div class="cell text-right"><?php wc_cart_totals_subtotal_html(); ?></div>
		</div>
		
		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
		<div class="t-row cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
			<div class="cell"><strong><?php wc_cart_totals_coupon_label( $coupon ); ?></strong></div>
			<div class="cell text-right"><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
		</div>
		<?php endforeach ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

		<div class="t-row">
			<div class="cell"><strong><?php _e( 'Shipping', 'woocommerce' ); ?></strong></div>
			<div class="cell text-right"><?php woocommerce_shipping_calculator(); ?></div>
		</div>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
		<div class="t-row fee">
			<div class="cell"><strong><?php echo esc_html( $fee->name ); ?></strong></div>
			<div class="cell text-right"><?php wc_cart_totals_fee_html( $fee ); ?></div>
		</div>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) :
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
					? sprintf( ' <small>(' . __( 'estimated for %s', 'woocommerce' ) . ')</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] )
					: '';

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
				<div class="t-row tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
					<div class="cell"><strong><?php echo esc_html( $tax->label ) . $estimated_text; ?></strong></div>
					<div class="cell text-right"><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
				</div>
				<?php endforeach; ?>
			<?php else : ?>
			<div class="t-row tax-total">
				<div class="cell"><strong><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; ?></strong></div>
				<div class="cell text-right"><?php wc_cart_totals_taxes_total_html(); ?></div>
			</div>
			<?php endif; ?>
		<?php endif; ?>

	</div>

	<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

	<div class="table total">
		<div class="t-row">
			<div class="cell"><?php _e( 'Total', 'woocommerce' ); ?></div>
			<div class="cell text-right"><strong><?php wc_cart_totals_order_total_html(); ?></strong></div>
		</div>
	</div>

	<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	<a class="btn btn-success btn-lg btn-block" href="<?php echo get_permalink( wc_get_page_id( 'checkout' ) ); ?>"><?php echo pll_e( 'Realizar Compra', 'efl'); ?></a>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>
</div>