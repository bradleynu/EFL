<div class="products">
  <div class="frame">
    <ul class="slidee">
      <?php 
      foreach($all_categories as $category):
      var_dump($category);
        $thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true ); 
        $image = wp_get_attachment_url( $thumbnail_id ); 
        $catlink = get_category_link($category);
        ?>
    <li class="product">
      <img width="169" height="300" src="<?php echo $image; ?>" class="attachment-medium size-medium wp-post-image" >
         <p class="product_title"><?php echo $category->name ?></p>
        <a href="<?php echo $catlink ?>"><span><?php echo esc_html__( 'Ver Categoria', 'lanco' ); ?></span></a>
      </li>
      <?php endforeach ?>
    </ul>
    <div class="scrollbar">
      <div class="handle"></div>
    </div>
    <div class="arrow prevPage"><span class="fa fa-caret-left"></span></div>
    <div class="arrow nextPage"><span class="fa fa-caret-right"></span></div>
  </div>
</div>
