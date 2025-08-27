<?php

namespace AAWP\Elementor;

/**
 * Elementor Compatibility.
 *
 * @since 3.19
 */
class Elementor {

	/**
	 * Are we ready?
	 *
	 * @since 3.19
	 *
	 * @return bool
	 */
	public function allow_load() {

		return (bool) did_action( 'elementor/loaded' );
	}

	/**
	 * Initialize.
	 *
	 * @since 3.19.
	 */
	public function init() {

		if ( ! $this->allow_load() || ! class_exists( '\Elementor\Plugin' ) ) {
			return;
		}

		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'load_scripts' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_widget' ) );
	}

	/**
	 * Load required scripts on Elementor pages.
	 *
	 * @since 3.19
	 */
	public function load_scripts() {
		\aawp_scripts();

		/**
		 * Admin scripts is required for the product search to function.
		 */
		\aawp_admin_scripts();

		wp_add_inline_script(
			'aawp',
			'var aawp_elementor_data = ' . wp_json_encode(
				array(
					'shortcode' => \aawp_get_shortcode(),
				)
			),
			'before'
		);

		$this->add_inline_script_for_product_search();

		/**
		 * Styles are added inline. These styles are specific to Elementor widget product search
		 * because admin styles aren't loaded on frontend or in the elementor screen.
		 *
		 * @since 3.31.0
		 */
		wp_add_inline_style(
			'aawp',
			'button.aawp-table-add-products-search, span.button.aawp-modal__button, span.aawp-table-button, #aawp-ajax-search-input {
				font: inherit;
				color: #32373c;
				background-color: #f7f7f7;
				border: 1px solid #ccc;
				border-radius: 4px;
				padding: 6px 6px;
				cursor: pointer;
				line-height: 1.5;
			}
			
			button.aawp-table-add-products-search:hover, span.button.aawp-modal__button:hover, span.aawp-table-button:hover {
			   background-color: #e2e2e2;
			}
			
			#aawp-ajax-search-input {
			   cursor: text;
			   margin-bottom: 10px;
			}'
		);
	}

	/**
	 * Inline script for product search Modal.
	 *
	 * @since 3.19.
	 */
	public function add_inline_script_for_product_search() {

		// Load modal box for product(s) search.
		add_action(
			'wp_footer',
			function () {

				ob_start();

				\aawp_admin_the_table_product_search_modal();

				?>
				<input type="hidden" id="aawp-ajax-search-items-selected" value="" />
				<?php

				echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		);
	}

	/**
	 * Register AAWP Widget.
	 *
	 * @since 3.19
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 * @return void
	 */
	public function register_widget( $widgets_manager ) {

		include_once AAWP_PLUGIN_DIR . 'src/Elementor/Widget.php';

		$widgets_manager->register( new Widget() );
	}
}
