<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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
 * @version     3.0.0
 */
 ?>

 <?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
<div class="product">
<div class="row">
	<div class="col-lg-7 col-md-6 test11">
		<?php
			/**
			 * woocommerce_before_single_product_summary hook.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		?>
	</div>
	<div class="col-lg-5 col-md-6">
		<H1 itemprop="name"><?php the_title(); ?></H1>
		<div class="stars">
			<?php woocommerce_template_single_rating() ?>
		</div>
		<!-- <a class="btn btn-info btn-block btn-lg" href="#"><?php echo pll_e( 'Comprar con un click ', 'efl'); ?> </a>
		<a class="btn btn-success btn-block btn-lg" href="#"><?php echo pll_e( 'Agregar a carrito', 'efl'); ?></a> -->
		<?php
			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>
	</div>
</div>
<div class="row top-padding">
	<div class="col-md-8">
		<?php
			/**
			 * woocommerce_after_single_product_summary hook.
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
		?>
	</div>
	<div class="col-md-4">
		<div class="sidebar">
			<div class="widget widget-recommended-products">
				<?php woocommerce_output_related_products() ?>
			</div>
		</div>
	</div>
</div>

	</div>
<?php
// Verificar si el producto actual pertenece a una categoría de Rompe Pecho
$product_id = get_the_ID();
$product_cats = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'slugs'));

// Slugs de categorías Rompe Pecho
$es_cat_slug = 'rompepecho'; // Slug de la categoría en español
$en_cat_slug = 'rompepecho-en'; // Slug de la categoría en inglés

// Verificar si el producto pertenece a alguna categoría de Rompe Pecho
$is_rompe_pecho_product = false;
foreach ($product_cats as $cat) {
    if ($cat === $es_cat_slug || $cat === $en_cat_slug) {
        $is_rompe_pecho_product = true;
        break;
    }
}

// Si es un producto Rompe Pecho, mostrar el iframe según el idioma
if ($is_rompe_pecho_product && function_exists('pll_current_language')) {
    $current_lang = pll_current_language();
    
    // Definir las URLs de los iframes según el idioma
    $iframe_url = '';
    $table_title = '';
    
    if ($current_lang === 'es') {
        $iframe_url = 'https://efficientlabs.com/es/tabla-comparativa-rompe-pecho/';
        $table_title = 'Tabla Comparativa de Productos Rompe Pecho';
    } else {
        $iframe_url = 'https://efficientlabs.com/en/comparative-table-rompe-pecho/';
        $table_title = 'Rompe Pecho Product Comparison Table';
    }
    
    // Mostrar el iframe
    if (!empty($iframe_url)) {
        echo '<div class="row full-width rompe-pecho-comparison-container">';
        echo '<div class="col-md-12">';
        echo '<div class="rompe-pecho-comparison-iframe-wrapper">';
        echo '<iframe src="' . esc_url($iframe_url) . '" width="100%" height="900" frameborder="0" style="margin: 30px 0;"></iframe>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

do_action( 'woocommerce_after_single_product' ); 
?>