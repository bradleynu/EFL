<?php

namespace AAWP\API;

/**
 * Search functionality.
 *
 * @since 3.30.0
 */
class Search {

	/**
	 * Search Endpoint.
     *
     * @since 3.30.0
	 *
	 * @var $endpoint The search API endpoint.
	 */
	private $endpoint = 'https://api.getaawp.com/v1/search/products';

	/**
	 * Get products from AAWP API by search term.
	 *
	 * @param string $term The Search Term.
	 * @param int    $count The number of products to display.
	 * @param string Sort the products by.
	 *
     * @since 3.30.0
	 */
	private function get_products( $term, $count = 10, $sortBy = '' ) {

        if ( defined( 'AAWP_API_URL' ) ) {
			$this->endpoint = AAWP_API_URL . '/search/products';
		}

		// Log the search term.
		aawp_log( 'AAWP Search API', 'Search Term: <code>' . $term . '</code>' );

		// Data to be passed to the API.
		$data = [
			'search_term' => $term,
			'store'       => \aawp_get_option( 'country', 'api' ),
			'sortby'      => $sortBy
		];

		// Options to the API Call.
		$options = [
			'body'        => wp_json_encode( $data ),
			'headers'     => [
				'Content-Type'  => 'application/json',
				'Authorization' => \aawp_get_option( 'key', 'licensing' ),
				'AAWP-Version'  => AAWP_VERSION,
				'AAWP-Referer-Domain' => wp_parse_url( site_url(), PHP_URL_HOST )
			],
			'timeout'     => 60,
			'redirection' => 5,
			'blocking'    => true,
			'httpversion' => '1.0',
			'sslverify'   => true,
			'data_format' => 'body',
		];

		// Remote API Call.
		$response = wp_remote_post( $this->endpoint, $options );

		// API call error.
		if ( is_wp_error( $response ) ) {
			aawp_log( 'AAWP Search API', '<code>' . print_r( $response->get_error_message(), true ) . '</code>' ); //phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
			return [];
		}

		// API call unexpected response.
		if ( ! isset( $response['response']['code'] ) || '200' != $response['response']['code'] ) { //phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
			aawp_log( 'AAWP Search API', '<code>' . print_r( $response['body'], true ) . '</code>' ); //phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r

			$body    = json_decode( $response['body'], true );
			$code    = isset( $body['code'] ) ? $body['code'] : '0';
			$message = isset( $body['message'] ) ? $body['message'] : 'unknown';

			set_transient( 'aawp_products_api_error', $code . ': ' . $message, 24 * HOUR_IN_SECONDS );
		}

		// Expected response. Decode the json format.
		$products = json_decode( $response['body'], true );

		if ( isset( $products['message'] ) ) {
			aawp_log( 'AAWP Search API', $products['message'] );
		}

		return ! empty( $products ) && is_array( $products ) ? array_slice( $products, 0, absint( $count ) ) : [];
	}

	/**
	 * Building HTML markup for search. Very similar to template.
	 * Existing template should be re-factored to make sure we use same search template for both Amazon & our own API.
	 *
	 * @see '../includes/admin/templates/ajax-search-results.php';
	 *
     * @since 3.30.0
	 */
	public function build_template( $keyword ) {

		$products = $this->get_products( $keyword, 10 );

		// In case the response has any message, show message instead.
		if ( ! empty( $products['code'] ) && ! empty( $products['message'] ) ) {
			return '<p class="aawp-notice aawp-notice--error">' . esc_html( $products['code'] ) . ': ' .  esc_html( $products['message'] ) . '</p>';
		}

		// In edge cases.
		if ( empty( $products ) ) {
			return '<p class="aawp-notice aawp-notice--info">' . __( 'No products found.', 'aawp' ) . '</p>';
		}

		$html = '<div class="aawp-ajax-search-items">';
		foreach ( $products as $product ) {

			if ( empty( $product['asin'] ) || empty( $product['title'] ) || empty( $product['image'] ) ) {
				continue;
			}

			$price    = ! empty( $product['price']['raw'] ) ? $product['price']['raw'] : '';
			$is_prime = ! empty( $product['is_prime'] );

			ob_start();
			?>

			<div class="aawp-ajax-search-item" data-aawp-ajax-search-item="<?php echo $product['asin']; ?>">
				<span class="aawp-ajax-search-item__thumb">
					<img src="<?php echo $product['image']; ?>" alt="thumbnail" />
				</span>
				
				<span class="aawp-ajax-search-item__content">
					<span class="aawp-ajax-search-item__title">
						<?php echo aawp_truncate_string( $product['title'], 40 ); ?>
					</span>
					
					<?php if ( ! empty( $price ) ) { ?>
						<span class="aawp-ajax-search-item__price">
							<?php echo $price; ?>
								<?php if ( $is_prime ) { ?>
									<span class="aawp-check-prime"></span>
								<?php } ?>
						</span>
					<?php } ?>
				</span>
			</div>
			<?php

			$html .= ob_get_clean();
		}//end foreach

		$html .= '</div>';

		return ! empty( $html ) ? $html : '';
	}
}