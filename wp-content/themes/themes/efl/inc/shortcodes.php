<?php

function product_categories_shortcode() {
	  $taxonomy     = 'product_cat';
	  $orderby      = 'description';  
	  $show_count   = 0;      // 1 for yes, 0 for no
	  $pad_counts   = 0;      // 1 for yes, 0 for no
	  $hierarchical = 1;      // 1 for yes, 0 for no  
	  $title        = '';  
	  $empty        = 0;

	  $args = array(
	         'taxonomy'     => $taxonomy,
	         'orderby'      => $orderby,
	         'show_count'   => $show_count,
	         'pad_counts'   => $pad_counts,
	         'hierarchical' => $hierarchical,
	         'title_li'     => $title,
	 		'posts_per_page' => -1,
	         'hide_empty'   => $empty
	  );
	 $all_categories = get_categories( $args );

	 ob_start();

	require STYLESHEETPATH . '/shortcodes/categories-grid.php';
	
	return ob_get_clean();
}

function lanco_related_views_shortcode() {
	$products = get_posts(array(
		'post_type' => 'product',
		'tax_query' => array(
	        array(
	            'taxonomy' => 'product_visibility',
	            'field'    => 'slug',
	            'terms'    => 'featured'
	        )
	    ),
	));

	ob_start();

	require STYLESHEETPATH . '/shortcodes/products-carousel.php';

	return ob_get_clean();
}

function lanco_recommended_shortcode() {
	$products = get_posts(array(
		'post_type' => 'product',
		'post__in' => wc_get_product_ids_on_sale(),
		'posts_per_page' => -1,
		'orderby'   => 'date',
	    'sort_order' => 'asc'
	));

	ob_start();

	require STYLESHEETPATH . '/shortcodes/products-carousel.php';

	return ob_get_clean();
}

function lanco_viewed_products_shortcode() {
	$viewd = !empty($_COOKIE['lanco_viewed_products']) ? json_decode($_COOKIE['lanco_viewed_products']) : array();

	if(count($viewd) == 0) {
		return '<p>'.esc_html__( 'No has visto ningún producto', 'lanco' ).'</p>';
	}

	global $woocommerce_loop;

	$products = new WP_Query( array(
		'posts_per_page' => 12,
		'post_type' => 'product',
		'post__in' => $viewd
	));
	$columns = 4;
	$woocommerce_loop['columns'] = $columns;
	$woocommerce_loop['name']    = 'history';

	ob_start();

	if ( $products->have_posts() ) {
		?>

		<?php do_action( "woocommerce_shortcode_before_{$loop_name}_loop" ); ?>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

		<?php do_action( "woocommerce_shortcode_after_{$loop_name}_loop" ); ?>

		<?php
	} else {
		do_action( "woocommerce_shortcode_{$loop_name}_loop_no_results" );
	}

	woocommerce_reset_loop();
	wp_reset_postdata();

	return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
}

add_shortcode( 'lanco_cat', 'product_categories_shortcode' );
add_shortcode( 'lanco_related_views', 'lanco_related_views_shortcode' );
add_shortcode( 'lanco_recommended', 'lanco_recommended_shortcode' );
add_shortcode( 'lanco_viewed_products', 'lanco_viewed_products_shortcode' );