<?php /** Template Name: homepage */
      get_header();
      $title1 = get_field('categories_title');
      $title2 = get_field('us_title1');
      $title3 = get_field('us_title2');
      $desc = get_field('us_desc');
      $img = get_field('us_picture');
      $bgunm = get_field('bg_head');
		$rompe_pecho = get_field('rompe_pecho');
   ?>
<section id="hero">
   <img src="<?php echo $bgunm; ?>" alt="">
	<h1 style="display: none;">Efficient Laboratories</h1>
</section>
<section>
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <h3 class="home-title"><?php echo $title1; ?></h3>
         </div>
      </div>
   </div>
</section>
<section class="container-fluid">
<div class="row hide-mobile">
    <?php 
        $taxonomy     = 'product_cat';
        $args = array(
            'taxonomy'     => $taxonomy,
            'orderby'      => 'description',
            'order'        => 'ASC',
            'hide_empty'   => false,
            'parent'       => 0,
			'exclude'      => array(19)
        );
        $all_categories = get_terms( $args );
    ?>
    <div class="">
        <div class="owl-carousel owl-theme cate">
            <div class="category-wrapper row">
                <?php $count = 1; foreach ( $all_categories as $K => $category ) :
				if($category->term_id != 441):
                    $thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true ); 
                    $image = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : ''; // Check if thumbnail ID exists
                    $catlink = get_term_link( $category, $taxonomy );
                ?>
                <div class="product-category col-md-6 <?php echo ($K == 3) ? "min-cat" : "" ?>">
                    <a href="<?php echo $catlink ?>">
                        <?php if ( $image ) : ?>
                            <img src="<?php echo $image; ?>" class="attachment-medium size-medium wp-post-image" >
                        <?php endif; ?>
                        <p class="product_title "><?php echo $category->name ?></p>
                    </a>
                </div>
                <?php if ($count % 4 == 0) echo '</div><div>';
                    $count++;
                ?>
                <?php endif; endforeach ?>
            </div>
        </div>
    </div>
</div>

<div style="display:none;" class="row show-mobile">
    <?php 
        $taxonomy     = 'product_cat';
        $orderby      = 'description';  
        $show_count   = 0;
        $pad_counts   = 0;
        $hierarchical = 0;  
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
            'parent' => 0,
            'hide_empty'   => $empty,
			'exclude'      => array(441)
        );
        $all_categories = get_categories( $args );
    ?>
    <div class="">
        <div class="owl-carousel owl-theme catemobile">
            <?php foreach ( $all_categories as $K => $category ) :
                $thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true ); 
                $image = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : ''; // Check if thumbnail ID exists
                $catlink = get_category_link( $category );
            ?>
            <div class="category-wrapper row">
                <div class="product-category col-md-6 <?php echo ($K == 3) ? "min-cat" : "" ?>">
                    <a href="<?php echo $catlink ?>">
                        <?php if ( $image ) : ?>
                            <img src="<?php echo $image; ?>" class="attachment-medium size-medium wp-post-image" >
                        <?php endif; ?>
                        <p class="product_title <?php echo ($K == 2 || $K == 3 || $K == 6 || $K == 7 || $K == 10 || $K == 11) ? 'text-white' : '' ?>"><?php echo $category->name ?></p>
                    </a>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</div>
</section>
<section id="rompe-pecho-section" class="rompe-pecho-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $rompe_pecho['image']; ?>" alt="" class="img-fluid">
            </div>
            <div class="col-md-8">
                <h2 class="rompe-pecho-title"><?php echo $rompe_pecho['title']; ?></h2>
                <p class="rompe-pecho-description"><?php echo $rompe_pecho['desc']; ?></p>
                <a href="<?php echo $rompe_pecho['url']; ?>" class="rompe-pecho-link">Ver más<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</section>
<section id="life">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <h3 class="home-title" style="position: relative;top: -52px;z-index: 99;"><?php echo $title2; ?></h3>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <h2><?php echo $title3; ?></h2>
            <p><?php echo $desc; ?></p>
            <img src="<?php echo $img; ?>" alt="">
         </div>
      </div>
   </div>
</section>
<?php get_footer(); ?>