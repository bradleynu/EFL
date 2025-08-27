<?php

class Lanco_Main_Menu_Walker extends Walker_Nav_Menu {

	public $display_history_submenu = false;

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );
		if($this->display_history_submenu) {
			$output .= "{$n}{$indent}<div class=\"mega-menu\"><div class=\"carousel owl-carousel owl-theme owl-hidden\">{$n}";
		} else {
			$output .= "{$n}{$indent}<ul class=\"sub-menu submenu list-unstyled\">{$n}";
		}
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );
		if($this->display_history_submenu) {
			$this->display_history_submenu = false;
			$output .= '</div></div>';
		} else {
			$output .= "$indent</ul>{$n}";
		}
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$has_megamenu = false;

		if(is_array($item->classes) && in_array('menu-item-has-children', $item->classes)) {


			$children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
			if($children[0]->post_title == '[wc_browsed_history]') {
				$this->display_history_submenu = true;
				$has_megamenu = true;
			}
		}

		if($item->post_title == '[wc_browsed_history]') {
			$output.= $this->_historySubmenu();
			return;
		}

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		if($item->post_title == '[wc_browsed_history]') {
			$this->display_history_submenu = true;
		}

		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		if($has_megamenu) {
			$classes[] = 'has-megamenu';
		} else if(in_array('menu-item-has-children', $classes)) {
			$classes[] = 'has-submenu';
		}

		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if($item->post_title == '[wc_browsed_history]') 
			return;

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$output .= "</li>{$n}";
	}

	protected function _historySubmenu() {
		$viewd = !empty($_COOKIE['lanco_viewed_products']) ? json_decode($_COOKIE['lanco_viewed_products']) : array();

		if(count($viewd) == 0) {
			return '<a class="product see-all">'.esc_html__( 'No has visto productos', 'lanco' ).'</a>';
		}

		$products = get_posts(array(
			'posts_per_page' => 10,
			'post_type' => 'product',
			'post__in' => $viewd
		));

		ob_start(); ?>

		<?php foreach($products as $product): ?>
		<a class="product" href="<?php echo get_permalink( $product->ID ); ?>">
			<?php echo get_the_post_thumbnail( $product->ID, 'thumbnail' ); ?>
			<p><?php echo get_the_title( $product->ID ); ?></p>
		</a>
		<?php endforeach ?>
		<a class="product see-all" href="/history"><?php esc_html_e( 'Ver historial Completo', 'lanco' ); ?></a>

		<?php return ob_get_clean();
	}

}