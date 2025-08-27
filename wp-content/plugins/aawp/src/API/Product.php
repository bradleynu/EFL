<?php

namespace AAWP\API;

/**
 * Single Product.
 *
 * @since 3.30.0
 */
class Product {

	/**
	 * Single product API Endpoint.
	 *
	 * @since 3.30.0
	 *
	 * @var $endpoint The single product API endpoint.
	 */
	private $endpoint = 'https://api.getaawp.com/v1/get/product';

	/**
	 * Get product from AAWP API.
	 *
	 * @since 3.30.0
	 *
	 * @param array $asin ASIN.
	 *
	 * @return mixed|array The product information or void.
	 */
	public function get_product( $asin ) {

		if ( defined( 'AAWP_API_URL' ) ) {
			$this->endpoint = AAWP_API_URL . '/get/product';
		}

		// Data to be passed to the API.
		$data = [
			'asin'  => $asin,
			'store' => \aawp_get_option( 'country', 'api' ),
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
			aawp_log( 'AAWP Product API', '<code>' . print_r( $response->get_error_message(), true ) . '</code>' ); //phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
			set_transient( 'aawp_products_api_error', $response->get_error_message(), 24 * HOUR_IN_SECONDS );
			return;
		}

		// API call unexpected response.
		if ( ! isset( $response['response']['code'] ) ) { //phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison

			aawp_log( 'AAWP Product API', '<code>' . print_r( $response['body'], true ) . '</code>' ); //phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
			set_transient( 'aawp_products_api_error', '', 24 * HOUR_IN_SECONDS );
			return;
		}

		// General response errors.
		if ( isset( $response['response']['code'] ) && isset( $response['body'] ) && 200 !== $response['response']['code'] ) {

			// Others.
			aawp_log( 'AAWP Product API', '<code>' . print_r( $response['body'], true ) . '</code>' ); //phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r

			$body    = json_decode( $response['body'], true );
			$code    = isset( $body['code'] ) ? $body['code'] : '0';
			$message = isset( $body['message'] ) ? $body['message'] : 'unknown';

			if ( aawp_is_user_editor() ) {
				echo '<p style="color:red"> ERROR ' . $code . ': ' . $message . '</p>';
			}

			set_transient( 'aawp_products_api_error', $code . ': ' . $message, 24 * HOUR_IN_SECONDS );

			return;
		}

		// Expected response. Decode the json format.
		$product = json_decode( $response['body'], true );

		// Just in case.
		if ( empty( $product ) || empty( $product['asin'] ) ) {
			aawp_log( 'AAWP Product API', sprintf( wp_kses( __( 'No product found or invalid ASIN: <code> %s </code>', 'aawp' ), [ 'code' => [] ] ), $asin ) );
			return;
		}

		// Product source.
		if ( ! empty( $product['source'] ) ) {
			aawp_log( 'AAWP Product API', 'Fetched product <code>' . $product['asin'] . '</code> from ' . $product['source'] );
		}

		// Product Usage.
		if ( ! empty( $product['usage'] ) ) {
			$this->set_usage_count( $product['usage'] );
		}

		// Remove error value.
		delete_transient( 'aawp_products_api_error' );

		do_action( 'aawp_api_after_product_fetched', $data );

		// Return the formatted product.
		return $this->format_product( $product );
	}

	/**
	 * Format the product coming from our API to our own db format.
	 *
	 * @param array $product The product information.
	 *
	 * @return array The product formatted.
	 */
	private function format_product( $product ) {

		$data = [
			'status'              => 'active',
			'asin'                => $product['asin'],
			'ean'                 => '',
			'isbn'                => ! empty( $product['isbn_10'] ) ? $product['isbn_10'] : '',
			'binding'             => '',
			'product_group'       => '',
			'title'               => ! empty( $product['title'] ) ? $product['title'] : '',
			'url'                 => $this->get_url( $product['asin'] ),
			'image_ids'           => $this->get_image_ids( $product ),
			'features'            => $this->get_features( $product ),
			'attributes'          => '',
			'availability'        => ! empty( $product['buybox_winner']['availability'] ) ? $this->is_available( $product['buybox_winner']['availability'] ) : '',
			'currency'            => ! empty( $product['buybox_winner']['price']['currency'] ) ? $product['buybox_winner']['price']['currency'] : '',
			'price'               => ! empty( $product['buybox_winner']['price']['value'] ) ? $product['buybox_winner']['price']['value'] : '',
			'savings'             => ! empty( $product['buybox_winner'] ) ? $this->get_savings( $product['buybox_winner'] ) : '',
			'savings_percentage'  => ! empty( $product['buybox_winner'] ) ? $this->get_savings_percentage( $product['buybox_winner'] ) : '',
			'savings_basis'       => ! empty( $product['buybox_winner']['rrp']['value'] ) ? $product['buybox_winner']['rrp']['value'] : '',
			'salesrank'           => '',
			'is_prime'            => ! empty( $product['buybox_winner']['is_prime'] ) ? $product['buybox_winner']['is_prime'] : '',
			'is_amazon_fulfilled' => ! empty( $product['buybox_winner']['fulfillment'] ) ? $this->is_fulfilled_by_amazon( $product['buybox_winner']['fulfillment'] ) : '',
			'shipping_charges'    => ! empty( $product['buybox_winner']['shipping']['value'] ) ? $product['buybox_winner']['shipping']['value'] : '',
			'rating'              => ! empty( $product['rating'] ) ? $product['rating'] : '',
			'reviews'             => ! empty( $product['ratings_total'] ) ? $product['ratings_total'] : '',
			'reviews_updated'     => '',
		];

		// Add product to db & return.
		return $this->add_product( $data );
	}

	/**
	 * Get product URL.
	 *
	 * @param string $asin The product asin.
	 *
	 * @return string The formatted URL with tag placeholder.
	 */
	private function get_url( $asin ) {
		return 'https://www.amazon.' . AAWP_STORE . '/dp/' . $asin . '?tag=' . AAWP_PLACEHOLDER_TRACKING_ID;
	}

	/**
	 * Get image IDs from the image Urls.
	 *
	 * @param array $product The product information.
	 */
	private function get_image_ids( $product ) {

		$images = ! empty( $product['images'] ) ? $product['images'] : [];

		$image_urls = [];
		if ( empty( $images ) && ! empty( $product['main_image']['link'] ) ) {
			$image_urls[] = $product['main_image']['link'];
		}

		foreach ( $images as $image ) {
			$image_urls[] = $image['link'];
		}

		return \aawp_get_product_image_ids_from_urls( $image_urls, true );
	}

	/**
	 * Get features bullet points/description.
	 *
	 * @param array $product The product information.
	 *
	 * @since 3.30.5
	 */
	private function get_features( $product ) {

		switch ( true ) {
			case ! empty( $product['feature_bullets'] ):
				return maybe_serialize( $product['feature_bullets'] );

			case ! empty( $product['description'] ):
				return serialize( explode( '.', $product['description'] ) );

			case ! empty( $product['book_description'] ):
				return serialize( explode( '.', $product['book_description'] ) );

			default:
				return '';
		}
	}

	/**
	 * Check if the product is available.
	 *
	 * @param array $availability The availability attributes from the API response.
	 *
	 * @return bool
	 */
	private function is_available( $availability ) {
		return isset( $availability['type'] ) && 'in_stock' === $availability['type'];
	}

	/**
	 * Check if the product is amazon fulfilled.
	 *
	 * @param array $fulfillment The fulfillment attributes from the API response.
	 *
	 * @return bool
	 */
	private function is_fulfilled_by_amazon( $fulfillment ) {
		return ! empty( $fulfillment['is_fulfilled_by_amazon'] );
	}

	/**
	 * Get Saving from the price.
	 *
	 * @param array $price Various prices to calculate the savings.
	 *
	 * @since 3.30
	 *
	 * @return int|string The savings price value.
	 */
	public function get_savings( $price ) {
		return isset( $price['price']['value'], $price['rrp']['value'] ) ? $price['rrp']['value'] - $price['price']['value'] : '';
	}

	/**
	 * Get Saving percentage from price.
	 *
	 * @param array $price Various prices to calculate the savings.
	 *
	 * @since 3.30
	 *
	 * @return int|float|string The percentage value without %
	 */
	public function get_savings_percentage( $price ) {
		return isset( $price['price']['value'], $price['rrp']['value'] ) ? 100 * ( $price['rrp']['value'] - $price['price']['value'] ) / $price['rrp']['value'] : '';
	}

	/**
	 * Add product to DB. Similar to aawp()->products->add() method.
	 *
	 * @param array $args The product information.
	 */
	private function add_product( $args ) {

		$db = new \AAWP_DB_Products();

		$product = $db->get_product_by( 'asin', $args['asin'], false );

		// Update or insert.
		if ( isset( $product->id ) ) {
			// @todo:: existing update functionality needs a refactor.
			$db->raw_data_update( $product->id, $args );
		} else {
			$product_id = $db->insert( $args );

			if ( $product_id ) {
				$product = \aawp_get_product( $product_id );
			}
		}

		return $product;
	}

	/**
	 * Renew products via API.
	 * Similar to aawp_renew_products() in product-functions.php which uses Amazon's API to renew.
	 *
	 * @param $asins An array of asins of products to renew.
	 *
	 * @return int Number of renewed products.
	 */
	public function renew( $asins ) {

		$this->aawp_set_time_limit();
		// @todo:: process in batch, instead.

		$renewed = 0;
		$chunks = array_chunk( $asins, 3 );

		foreach( $chunks as $asins ) {

			if ( empty( get_transient( 'aawp_products_api_error' ) ) ) {

				foreach ( $asins as $asin ) {
					$renew = $this->get_product( $asin );

					if ( ! empty( $renew ) ) {
						$renewed++;
					}
				}
			}
		}

		// @todo:: handle renewal errors.
		return $renewed;
	}

	/**
	 * Wrapper for set_time_limit to see if it is enabled.
	 *
	 * @param int $limit Time limit.
	 */
	private function aawp_set_time_limit( $limit = 0 ) {

		if ( function_exists( 'set_time_limit' ) && false === strpos( ini_get( 'disable_functions' ), 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) { // phpcs:ignore PHPCompatibility.IniDirectives.RemovedIniDirectives.safe_modeDeprecatedRemoved
			@set_time_limit( $limit ); // @codingStandardsIgnoreLine
		}
	}

	/**
	 * Set Usage.
	 *
	 * @param $usage Products API usage count.
	 *
	 * @since 3.30.
	 *
	 * @return void
	 */
	private function set_usage_count( $usage ) {
		update_option( 'aawp_products_api_usage_count', $usage );
	}
}
