<div class="products">
  <div class="frame">
    <ul class="slidee">
      <?php foreach($products as $product): ?>
      <li class="product">
        <?php 
        echo get_the_post_thumbnail( $product->ID, 'medium' );
        $product_single = wc_get_product( $product->ID );
        $p = new WC_Product($product);
        ?>
         <p class="product_title"><?php echo $product_single->get_title(); ?></p>
         <span class="product_price_carousel"><?php echo $p->get_price_html(); ?></span>
        <a href="<?php echo get_permalink( $product->ID ); ?>"><span><?php echo esc_html__( 'Ver Producto', 'lanco' ); ?></span></a>
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
