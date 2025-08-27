<?php

namespace AAWP\API;

/**
 * Usage Tracking.
 *
 * @since 3.20
 */
class UsageTracking {

	/**
	 * Usage tracking API Endpoint.
	 *
	 * @var $endpoint Usage tracking API Endpoint.
	 *
	 * @since 3.20
	 */
	private $endpoint = 'https://api.getaawp.com/v1/usage';

	/**
	 * Initialize the usage tracking.
	 *
	 * @since 3.20
	 */
	public function init() {

		if ( ! apply_filters( 'aawp_usage_data_enable', true ) ) {
			return;
		}

		if ( defined( 'AAWP_API_URL' ) ) {
			$this->endpoint = AAWP_API_URL . '/usage';
		}

		add_action( 'admin_init', [ $this, 'schedule' ] );
		add_action( 'aawp_usage_data', [ $this, 'api_call' ] );
	}

	/**
	 * Schedule the usage data task.
	 *
	 * @since 3.20
	 */
	public function schedule() {

		if ( false === as_next_scheduled_action( 'aawp_usage_data' ) ) {
			as_schedule_recurring_action( strtotime( '+ 3 days' ), DAY_IN_SECONDS * 3, 'aawp_usage_data', [], 'aawp' );
		}
	}

	/**
	 * Call the API.
	 *
	 * @since 3.20
	 */
	public function api_call() {

		$data = $this->get_basic_data();

		if ( ! empty( aawp_get_option( 'usage_optin', 'general' ) ) ) {
			$data = array_merge( $data, $this->get_telemetric_data() );
		}

		$options = [
			'body'        => wp_json_encode( $data ),
			'headers'     => [
				'Content-Type' => 'application/json',
			],
			'timeout'     => 60,
			'redirection' => 5,
			'blocking'    => true,
			'httpversion' => '1.0',
			'data_format' => 'body',
		];

		$response = wp_remote_post( $this->endpoint, $options );

		if ( is_wp_error( $response ) ) {
			aawp_log( 'AAWP Usage API', '<code>' . $response->get_error_message() . '</code>' ); //phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
			return;
		}

		if ( ! empty( $response['response']['code'] ) && ! empty( $response['response']['message'] ) ) {

			aawp_log( 'AAWP Usage API', '<code>' . $response['response']['code'] . '</code>' . $response['response']['message'] );
		}
	}

	/**
	 * Get basic data.
	 *
	 * @since 3.20
	 *
	 * @return array An array of data to send to API.
	 */
	private function get_basic_data() {

		global $wp_version;

		return [
			'site_url'     => wp_parse_url( site_url(), PHP_URL_HOST ),
			'php_version'  => PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION,
			'wp_version'   => $wp_version,
			'wp_lang'      => ! empty( get_bloginfo( 'language' ) ) ? get_bloginfo( 'language' ) : 'en',
			'aawp_version' => AAWP_VERSION,
			'aawp_license' => \aawp_get_option( 'key', 'licensing' ),
			'is_aawp_api_active' => (bool) \is_aawp_api_eligible(),
		];
	}

	/**
	 * Telemetric data.
	 *
	 * @since 3.22
	 *
	 * @return array An array of data to send to API.
	 */
	private function get_telemetric_data() {

		return [
			'comparison_tables'         => ( new \WP_Query( [ 'post_type' => 'aawp_table', 'posts_per_page' => -1 ] ) )->post_count,
			'active_products'           => (int) ( new \AAWP_DB_Products() )->count( [ 'status' => 'active' ] ),
			'invalid_products'          => (int) ( new \AAWP_DB_Products() )->count( [ 'status' => 'invalid' ] ),
			'bestseller_lists'          => (int) ( new \AAWP_DB_Lists() )->count( [ 'type' => 'bestseller' ] ),
			'new_releases_lists'        => (int) ( new \AAWP_DB_Lists() )->count( [ 'type' => 'new_releases' ] ),
			'click_tracking'            => (bool) ! empty( get_option( 'aawp_clicks_settings' )['enable'] ),
			'click_tracking_country'    => (bool) ! empty( get_option( 'aawp_clicks_settings' )['country'] ),
			'geotargeting'              => (bool) aawp_get_option( 'geotargeting', 'functions' ),
			'amazon_api_country'        => ! empty( aawp_get_option( 'country', 'api' ) ) ? aawp_get_option( 'country', 'api' ) : 'de',
			'multi_store_functionality' => (bool) aawp_get_option( 'multiple_stores', 'api' ),
			'cache_duration'            => (int) ! empty( aawp_get_option( 'cache_duration', 'general' ) ) ? aawp_get_option( 'cache_duration', 'general' ) : 720,
			'affiliate_link_type'       => ! empty( aawp_get_option( 'affiliate_links', 'general' ) ) ? aawp_get_option( 'affiliate_links', 'general' ) : 'standard',
			'image_proxy'               => (bool) aawp_get_option( 'image_proxy', 'output' ),
			'star_rating'               => (bool) aawp_get_option( 'star_rating_size', 'output' ),
			'load_assets_globally'      => (bool) aawp_get_option( 'load_assets_globally', 'output' ),
		];
	}
}
