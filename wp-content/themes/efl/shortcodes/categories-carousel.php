<?php
/**
 * Carrusel de categorías usando Sly.js
 * Shortcode que genera un carrusel horizontal de categorías de WooCommerce
 */

// Obtener categorías visibles
$all_categories = get_terms([
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
]);

if (empty($all_categories)) return;
?>

<div class="products categories"> <!-- Nota: se usa ambas clases para asegurar que Sly lo inicialice -->

  <div class="frame carousel-frame">
    <ul class="slidee">
      <?php foreach ($all_categories as $category):
          $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
          $image = wp_get_attachment_url($thumbnail_id);
          $catlink = get_term_link($category);
      ?>
      <li class="product">
        <img width="169" height="300" src="<?php echo esc_url($image); ?>" class="attachment-medium size-medium wp-post-image" alt="<?php echo esc_attr($category->name); ?>">
        <p class="product_title"><?php echo esc_html($category->name); ?></p>
        <a href="<?php echo esc_url($catlink); ?>">
          <span><?php echo esc_html__('Ver Categoría', 'lanco'); ?></span>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>

  <!-- Controles del carrusel -->
  <div class="scrollbar"><div class="handle"></div></div>
  <div class="arrow prevPage"><span class="fa fa-caret-left"></span></div>
  <div class="arrow nextPage"><span class="fa fa-caret-right"></span></div>
</div>
