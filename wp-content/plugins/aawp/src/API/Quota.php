<?php

namespace AAWP\API;

/**
 * Product Quota Check.
 *
 * @since 3.32.0
 */
class Quota {

	/**
	 * Product Quota Check Endpoint.
	 *
	 * @since 3.32.0
	 *
	 * @var $endpoint The product quota check API endpoint.
	 */
	private $endpoint = 'https://api.getaawp.com/v1/check/quota';

	/**
	 * Initialize.
	 *
	 * @since 3.32.0
	 */
	public function init() {

		if ( defined( 'AAWP_API_URL' ) ) {
			$this->endpoint = AAWP_API_URL . '/check/quota';
		}

		add_action( 'aawp_settings_process', array( $this, 'process' ) );
	}

	/**
	 * Validate the quota refresh button and update the quota.
	 *
	 * @since 3.32.0
	 */
	public function process( $post_data ) {

		if ( 'aawp_api' !== $post_data['option_page'] || ! isset( $post_data['aawp_api']['usage_quota'] ) ) {
			return;
		}

		// Remote API Call.
		$response = wp_remote_get( $this->endpoint . '/' . urlencode( \aawp_get_option( 'key', 'licensing' ) ) );

		$body = wp_remote_retrieve_body( $response );

		$usage_limit = absint( $body );

		update_option( 'aawp_products_api_usage_limit', $usage_limit );
	}
}
