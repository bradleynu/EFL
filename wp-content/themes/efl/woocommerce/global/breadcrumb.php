<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
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
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ): ?>

<div class="breadcrum breadcrum-list">
	<div class="container">
		<div class="border-bottom clearfix">
			<div class="pull-left">
				<div class="table reset">
					<div class="cell v-middle">
						<p>
						<?php woocommerce_result_count() ?>
						<?php foreach ( $breadcrumb as $key => $crumb ): ?>
							<?php 
								if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
									echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
								} else {
									echo '<span class="active">' . esc_html( $crumb[0] ) . '</span>';
								}
								if ( sizeof( $breadcrumb ) !== $key + 1 ) {
									echo ' > ';
								}
							?>
						<?php endforeach ?>
							
						</p>
					</div>
				</div>
			</div>
			<div class="pull-right">
				<div class="table reset">
					<div class="cell v-middle">
						<?php woocommerce_catalog_ordering() ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 

endif;
