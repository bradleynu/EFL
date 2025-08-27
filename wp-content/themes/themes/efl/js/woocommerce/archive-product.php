<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<section id="content">

<div class="content top-shadow">

<?php
	/**
	 * woocommerce_before_main_content hook.
	 *
	 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	 * @hooked woocommerce_breadcrumb - 20
	 */
	do_action( 'woocommerce_before_main_content' );
?>

<div class="container vertical-padding lanco-products">
	<div class="row">
		<div class="col-lg-3 col-md-4 hidden-xs hidden-sm">

			<?php
				/**
				 * woocommerce_sidebar hook.
				 *
				 * @hooked woocommerce_get_sidebar - 10
				 */
				do_action( 'woocommerce_sidebar' );
			?>

		</div>
		<div class="col-lg-9 col-md-8">
			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

				<!--<h1 class="products-page-title page-title"><?php woocommerce_page_title(); ?></h1>-->

			<?php endif; ?>

			<?php
				/**
				 * woocommerce_archive_description hook.
				 *
				 * @hooked woocommerce_taxonomy_archive_description - 10
				 * @hooked woocommerce_product_archive_description - 10
				 */
				do_action( 'woocommerce_archive_description' );
			?>

			<?php if ( have_posts() ) : ?>

				<?php
					/**
					 * woocommerce_before_shop_loop hook.
					 *
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					// do_action( 'woocommerce_before_shop_loop' );
				?>

				<?php woocommerce_product_loop_start(); ?>

					<?php woocommerce_product_subcategories(); ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>

			<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

				<?php wc_get_template( 'loop/no-products-found.php' ); ?>

			<?php endif; ?>
			<nav class="text-center" aria-label="Page navigation">
				<?php
					/**
					 * woocommerce_after_shop_loop hook.
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
				?>
			</nav>
		</div>
	</div>
</div>

<?php
	/**
	 * woocommerce_after_main_content hook.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action( 'woocommerce_after_main_content' );
?>

</div>

</section>

<?php $products = lanco_get_featured_products() ?>
<?php if(count($products)): ?>
<div class="widget widget-related-products woocommerce">
	<div class="container">
		<div class="border-top vertical-padding-min">
			<h3><?php echo pll_e( 'Productos Destacados', 'efl'); ?></h3>
			<div class="row products product-archive">
				<?php foreach($products as $product): ?>
				<?php $p = new WC_Product($product) ?>
				<div class="col-sm-4 col-md-2">
					<div class="product-item">
						<div class="thumbnail">
							<?php echo get_the_post_thumbnail( $product->ID, 'full' ); ?>
							<a href="<?php echo get_permalink( $product->ID ); ?>"><?php echo pll_e( 'Ver producto', 'efl'); ?></a>
						</div>
						<h5><?php echo get_the_title( $product->ID ); ?></h5>
						<?php if ( get_option( 'woocommerce_enable_review_rating' ) !== 'no' ): ?>
						<?php echo $p->get_rating_html() ?>
						<?php endif ?>
						<span class="price"><?php echo $p->get_price_html(); ?></span>
					</div>
				</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</div>
<?php endif ?>

<?php get_footer( 'shop' ); ?>
