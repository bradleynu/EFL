<div class="owl-carousel owl-theme cate">
  <div class="category-wrapper row">
  <?php $count=1; foreach($all_categories as $category) :
      $thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true ); 
      $image = wp_get_attachment_url( $thumbnail_id ); 
      $catlink = get_category_link($category);
    ?>
        <?php 
        $category_single = wc_get_product( $category->ID );
        $p = new WC_Product($category);
        ?>
         <div class="product-category col-md-6">
          <a href="<?php echo $catlink ?>">
            <img src="<?php echo $image; ?>" class="attachment-medium size-medium wp-post-image" >
            <p class="product_title"><?php echo $category->name ?></p>
            </a>
        </div>
        <?php if ($count%4==0) echo '</div><div>'; 
        $count++;
         ?>
    <?php endforeach ?>
    </div>
</div>