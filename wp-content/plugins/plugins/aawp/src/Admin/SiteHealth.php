<?php

namespace AAWP\Admin;

/**
 * Site Health.
 *
 * @since 3.32.0
 */
class SiteHealth {

	/**
	 * Indicate if Site Health is allowed to load.
	 *
	 * @since 3.32.0
	 *
	 * @return bool
	 */
	private function allow_load() {

		global $wp_version;

		return version_compare( $wp_version, '5.2', '>=' );
	}

	/**
	 * Init Site Health.
	 *
	 * @since 3.32.0
	 */
	final public function init() {

		if ( ! $this->allow_load() ) {
			return;
		}

		$this->hooks();
	}

	/**
	 * Integration hooks.
	 *
	 * @since 3.32.0
	 */
	protected function hooks() {

		add_filter( 'debug_information', array( $this, 'add_info_section' ) );
		add_filter( 'site_status_tests', array( $this, 'tests' ) );
	}

	/**
	 * Add AAWP section to Info tab.
	 *
	 * @since 3.32.0
	 *
	 * @param array $debug_info Array of all information.
	 *
	 * @return array Array with added AAWP info section.
	 */
	public function add_info_section( $debug_info ) { // phpcs:ignore Generic.Metrics.CyclomaticComplexity.TooHigh

		$aawp = array(
			'label'  => 'AAWP',
			'fields' => array(
				'version' => array(
					'label' => esc_html__( 'Version', 'aawp' ),
					'value' => AAWP_VERSION,
				),
			),
		);

		$aawp['fields']['products'] = array(
			'label' => esc_html__( 'Products', 'aawp' ),
			'value' => aawp_get_products_count(),
		);

		$aawp['fields']['lists'] = array(
			'label' => esc_html__( 'Lists', 'aawp' ),
			'value' => aawp_get_lists_count(),
		);

		$aawp['fields']['last_update'] = array(
			'label' => esc_html__( 'Last Update', 'aawp' ),
			'value' => aawp_datetime( aawp_get_cache_last_update() ),
		);

		$aawp['fields']['mbstring'] = array(
			'label' => esc_html__( 'PHP "mbstring" extension', 'aawp' ),
			'value' => extension_loaded( 'mbstring' ) ? 'Enabled' : 'Disabled',
		);

		$aawp['fields']['allow_url_fopen'] = array(
			'label' => esc_html__( 'PHP "allow_url_fopen" setting', 'aawp' ),
			'value' => ini_get( 'allow_url_fopen' ) ? 'Enabled' : 'Disabled',
		);

		$debug_info['aawp'] = $aawp;

		return $debug_info;
	}

	/**
	 * Add or modify which site status tests are run on a site.
	 *
	 * @since 3.32.0
	 *
	 * @param array $tests Site health tests registered.
	 *
	 * @return array
	 */
	public function tests( $tests ) {

		$tests['direct']['aawp_license'] = array(
			'label' => esc_html__( 'AAWP License', 'aawp' ),
			'test'  => array( $this, 'license_check' ),
		);

		$tests['direct']['aawp_allow_url_fopen'] = array(
			'label' => esc_html__( 'AAWP - allow_url_fopen() check', 'aawp' ),
			'test'  => array( $this, 'allow_url_fopen_check' ),
		);

		$tests['direct']['aawp_mbstring'] = array(
			'label' => esc_html__( 'AAWP - mbstring check', 'aawp' ),
			'test'  => array( $this, 'mbstring_check' ),
		);

		return $tests;
	}

	/**
	 * License Checks.
	 *
	 * @param $tests array Tests.
	 *
	 * @since 3.32.0
	 */
	public function license_check() {

		$status = ! empty( aawp_get_option( 'info', 'licensing' )['status'] ) ? aawp_get_option( 'info', 'licensing' )['status'] : '';

		$result = array(
			'label'       => sprintf( /* translators: %s license status */
				esc_html__( 'Your AAWP license is %s', 'aawp' ),
				$status
			),
			'status'      => $status === 'valid' ? 'good' : 'critical',
			'badge'       => array(
				'label' => esc_html__( 'Security', 'aawp' ),
				'color' => $status === 'valid' ? 'blue' : 'red',
			),
			'description' => sprintf(
				'<p>%s</p>',
				esc_html__( 'You have access to updates and support.', 'aawp' )
			),
			'actions'     => '',
			'test'        => 'aawp_license',
		);

		if ( $status === 'valid' ) {
			return $result;
		}

		$result['description'] = esc_html__( '❌ A valid AAWP license is required.', 'aawp' );

		$result['actions'] = sprintf(
			'<p><a href="%s">%s</a></p>',
			admin_url( 'admin.php?page=aawp-settings&tab=licensing' ),
			esc_html__( 'Enter a valid AAWP License.', 'aawp' )
		);

		return $result;
	}

	/**
	 * "allow_url_fopen" PHP Extension Check.
	 *
	 * @since 3.32.0
	 */
	public function allow_url_fopen_check() {

		$allow_url_fopen = ini_get( 'allow_url_fopen' );

		$result = array(
			'label'       => sprintf( /* translators: %s allow_url_fopen() status */
				esc_html__( 'PHP Extension allow_url_fopen() is %s', 'aawp' ),
				$allow_url_fopen ? 'enabled' : 'disabled'
			),
			'status'      => $allow_url_fopen ? 'good' : 'recommended',
			'badge'       => array(
				'label' => esc_html__( 'AAWP', 'aawp' ),
				'color' => $allow_url_fopen ? 'blue' : 'red',
			),
			'description' => sprintf(
				'<p>%s</p>',
				esc_html__( 'allow_url_fopen() is required for certain AAWP features to work.', 'aawp' )
			),
			'actions'     => '',
			'test'        => 'aawp_allow_url_fopen',
		);

		if ( $allow_url_fopen ) {
			return $result;
		}

		$result['description'] = esc_html__( '❌ PHP Extension allow_url_fopen() is not enabled. It is required for certain features of AAWP Plugin.', 'aawp' );

		return $result;
	}

	/**
	 * "mbstring" PHP Extension Check.
	 *
	 * @since 3.32.0
	 */
	public function mbstring_check() {

		$mbstring = extension_loaded( 'mbstring' );

		$result = array(
			'label'       => sprintf( /* translators: %s mbstring() status */
				esc_html__( 'PHP Extension mbstring is %s', 'aawp' ),
				$mbstring ? 'enabled' : 'disabled'
			),
			'status'      => $mbstring ? 'good' : 'recommended',
			'badge'       => array(
				'label' => esc_html__( 'AAWP', 'aawp' ),
				'color' => $mbstring ? 'blue' : 'red',
			),
			'description' => sprintf(
				'<p>%s</p>',
				esc_html__( 'mbstring PHP Extension is required for certain AAWP features to work.', 'aawp' )
			),
			'actions'     => '',
			'test'        => 'aawp_mbstring',
		);

		if ( $mbstring ) {
			return $result;
		}

		$result['description'] = esc_html__( '❌ PHP Extension mbstring is not enabled. It is required for certain features of AAWP Plugin.', 'aawp' );

		return $result;
	}
}
