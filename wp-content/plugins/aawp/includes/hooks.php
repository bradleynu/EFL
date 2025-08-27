<?php
/**
 * Hooks
 *
 * @since       3.2.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin scripts loader
 *
 * Only on plugin settings and widgets page
 *
 * @since       3.2.0
 */
function aawp_load_admin_scripts() {

	// Settings and Widgets page only
	$screen = get_current_screen();

	if ( ( isset( $screen->id ) && strpos( $screen->id, 'aawp' ) !== false ) || ( isset( $screen->base ) && $screen->base == 'widgets' || $screen->base === 'post' || $screen->base === 'site-editor' ) ) {
		do_action( 'aawp_load_admin_scripts' );
	}
}
add_action( 'admin_enqueue_scripts', 'aawp_load_admin_scripts' );

/**
 * Frontend scripts loader
 *
 * @since       3.2.0
 */
function aawp_load_frontend_scripts() {
	do_action( 'aawp_load_scripts' );
}
add_action( 'wp_enqueue_scripts', 'aawp_load_frontend_scripts', 20 );

/**
 * Head hook
 */
function aawp_wp_head() {

	if ( aawp_is_amp_endpoint() ) {
		return;
	}

	// Hook for functions
	do_action( 'aawp_wp_head' );
}
add_action( 'wp_head', 'aawp_wp_head' );

/**
 * Footer hook
 */
function aawp_wp_footer() {
	// Hook for functions
	do_action( 'aawp_wp_footer' );
}
add_action( 'wp_footer', 'aawp_wp_footer' );

/**
 * Replace translations
 *
 * Expecting: $search_replace['Bestseller Nr.'] = 'My Bestseller No.'; etc.
 */
function aawp_replace_translations( $translated_text, $text, $domain ) {

	if ( 'aawp' === $domain ) {

		$search_replace = apply_filters( 'aawp_replace_translations', array() );

		if ( is_array( $search_replace ) && sizeof( $search_replace ) > 0 ) {
			if ( isset( $search_replace[ $translated_text ] ) ) {
				$translated_text = sanitize_text_field( $search_replace[ $translated_text ] );
			}
		}
	}

	return $translated_text;
}
add_filter( 'gettext', 'aawp_replace_translations', 20, 3 );

/*
 * Overwriting default styles
 */
function aawp_overwrite_styles() {

	$styles = '';

	$styles = apply_filters( 'aawp_overwrite_styles', $styles );

	if ( ! empty( $styles ) ) {
		?>
<style><?php echo esc_html( $styles ); ?></style>
		<?php
	}
}
add_action( 'aawp_wp_footer', 'aawp_overwrite_styles', 15 );

/**
 * Overwrite default styles via settings
 *
 * @param $styles
 * @return string
 */
function aawp_overwrite_styles_by_settings( $styles ) {

	$output_settings = aawp_get_options( 'output' );

	// Description: Show on mobile devices
	if ( isset( $output_settings['description_show_mobile'] ) && $output_settings['description_show_mobile'] == '1' ) {
		$styles .= '.aawp .aawp-product--horizontal .aawp-product__description { display: block !important; }';
	}

	return $styles;
}
add_filter( 'aawp_overwrite_styles', 'aawp_overwrite_styles_by_settings' );

/*
 * Handle shortcodes in text widgets
 */
function aawp_widget_text( $widget_text ) {

	if ( has_shortcode( $widget_text, aawp_get_shortcode() ) ) {
		$shortcode = aawp_get_shortcode();
	} elseif ( has_shortcode( $widget_text, 'aawp' ) ) {
		$shortcode = 'aawp';
	} else {
		$shortcode = false;
	}

	if ( $shortcode ) {
		$widget_text = str_replace( '[' . $shortcode, '[' . $shortcode . ' origin="widget"', $widget_text );
	}

	return $widget_text;
}
add_filter( 'widget_text', 'aawp_widget_text', 1 );



/**
 * Maybe show disclaimer after template
 *
 * @param $args
 */
function aawp_show_disclaimer_after_template( $args ) {

	$options = aawp_get_options();

	// echo '<p>IS_WIDGET? '; var_dump( $args['is_widget'] ); echo '</p>';

	// Show only on position after
	$disclaimer_position = ( ! empty( $options['general']['disclaimer_position'] ) ) ? $options['general']['disclaimer_position'] : null;

	if ( ! $args['is_widget'] && ( ! $disclaimer_position || $disclaimer_position != 'after' ) ) {
		return;
	}

	$disclaimer_widget = ( isset( $options['general']['disclaimer_widget'] ) && '1' == $options['general']['disclaimer_widget'] ) ? true : false;

	if ( $args['is_widget'] && ( ( ! $disclaimer_position || $disclaimer_position != 'after' ) && ! $disclaimer_widget ) ) {
		return;
	}

	$disclaimer_text = ( ! empty( $options['general']['disclaimer_text'] ) ) ? $options['general']['disclaimer_text'] : null;

	if ( ! $disclaimer_text ) {
		return;
	}

	if ( strpos( $disclaimer_text, '%last_update%' ) !== false ) {

		if ( ! empty( $args['timestamp'] ) ) {
			$last_update = aawp_format_last_update( $args['timestamp'] );

			if ( $last_update ) {
				$disclaimer_text = aawp_replace_last_update_placeholder( $disclaimer_text, $last_update );
			}
		}
	}

	// Output
	echo '<p class="aawp-disclaimer">' . do_shortcode( stripslashes( $disclaimer_text ) ) . '</p>';
}
add_action( 'aawp_after_template', 'aawp_show_disclaimer_after_template', 10 );

/**
 * Maybe show disclaimer right after the post/page content
 *
 * @param $content
 *
 * @return string
 */
function aawp_show_disclaimer_after_content( $content ) {

	// Show only on single pages or posts
	if ( ! is_page() && ! is_single() ) {
		return $content;
	}

	$options = aawp_get_options();

	// Show only on position bottom
	$disclaimer_position = ( ! empty( $options['general']['disclaimer_position'] ) ) ? $options['general']['disclaimer_position'] : null;

	if ( ! $disclaimer_position || $disclaimer_position != 'bottom' ) {
		return $content;
	}

	// Show disclaimer
	$disclaimer_text = ( ! empty( $options['general']['disclaimer_text'] ) ) ? $options['general']['disclaimer_text'] : null;

	if ( ! $disclaimer_text ) {
		return $content;
	}

	// Last update
	if ( strpos( $disclaimer_text, '%last_update%' ) !== false ) {

		$last_update = aawp_get_cache_last_update();

		if ( ! empty( $last_update ) ) {
			$last_update = aawp_format_last_update( $last_update );

			if ( $last_update ) {
				$disclaimer_text = aawp_replace_last_update_placeholder( $disclaimer_text, $last_update );
			}
		}
	}

	// Output
	$content .= '<p class="aawp-disclaimer">' . do_shortcode( stripslashes( $disclaimer_text ) ) . '</p>';

	return $content;
}
add_filter( 'aawp_the_content', 'aawp_show_disclaimer_after_content', 15 );

/**
 * Maybe show credits after template
 *
 * @param $args
 */
function aawp_show_credits_after_template( $args ) {

	$options = aawp_get_options();

	// Show only on position after
	$credits_position = ( ! empty( $options['general']['credits_position'] ) ) ? $options['general']['credits_position'] : null;

	if ( ! $credits_position || $credits_position != 'after' ) {
		return;
	}

	// Output
	echo '<p class="aawp-credits">' . aawp_get_credits_link() . '</p>';
}
add_action( 'aawp_after_template', 'aawp_show_credits_after_template', 15 );

/**
 * Maybe show credits right after the post/page content
 *
 * @param $content
 *
 * @return string
 */
function aawp_show_credits_after_content( $content ) {

	$options = aawp_get_options();

	// Show only on single pages or posts
	if ( ! is_page() && ! is_single() ) {
		return $content;
	}

	// Show only on position bottom
	$credits_position = ( ! empty( $options['general']['credits_position'] ) ) ? $options['general']['credits_position'] : null;

	if ( ! $credits_position || $credits_position != 'bottom' ) {
		return $content;
	}

	// Output
	$content .= '<p class="aawp-credits">' . aawp_get_credits_link() . '</p>';

	return $content;
}

add_filter( 'aawp_the_content', 'aawp_show_credits_after_content', 25 );

/**
 * Maybe add shortcode support for text widgets
 *
 * @param $text
 *
 * @return string
 */
function aawp_theme_support_text_widget( $text ) {

	$options = aawp_get_options();

	if ( isset( $options['general']['theme_support_text_widget'] ) && $options['general']['theme_support_text_widget'] == '1' ) {
		return do_shortcode( $text );
	}

	return $text;
}
add_filter( 'widget_text', 'aawp_theme_support_text_widget' );

/**
 * Maybe add shortcode support for term descriptions
 *
 * @param $term_description
 *
 * @return string
 */
function aawp_theme_support_term_description( $term_description ) {

	$options = aawp_get_options();

	if ( isset( $options['general']['theme_support_term_description'] ) && $options['general']['theme_support_term_description'] == '1' ) {
		return do_shortcode( $term_description );
	}

	return $term_description;
}
add_filter( 'term_description', 'aawp_theme_support_term_description' );

/**
 * Maybe output custom setting css
 */
function aawp_load_custom_setting_css() {

	$custom_setting_css = '';
	$custom_setting_css = apply_filters( 'aawp_custom_setting_css', $custom_setting_css );

	if ( $custom_setting_css != '' ) {
		echo '<style type="text/css">' . stripslashes( $custom_setting_css ) . '</style>';
	}
}
add_action( 'aawp_wp_head', 'aawp_load_custom_setting_css', 20 );

/**
 * Maybe output custom css
 */
function aawp_load_custom_css() {

	$options = aawp_get_options();

	$custom_css_activated = ( isset( $options['output']['custom_css_activated'] ) && $options['output']['custom_css_activated'] == '1' ) ? 1 : 0;
	$custom_css           = ( ! empty( $options['output']['custom_css'] ) ) ? $options['output']['custom_css'] : '';

	if ( $custom_css_activated == '1' && $custom_css != '' ) {
		echo '<style type="text/css">' . $custom_css . '</style>'; // tripslashes( $custom_css )
	}
}
add_action( 'aawp_wp_head', 'aawp_load_custom_css', 30 );

/**
 * Maybe cleanup shortcode output in order to remove empy p/br tags
 *
 * @param $content
 *
 * @return string
 */
function aawp_maybe_cleanup_shortcode_output( $content ) {

	$options = aawp_get_options();

	if ( isset( $options['general']['cleanup_shortcode_output'] ) && $options['general']['cleanup_shortcode_output'] === '1' ) {

		$shortcode_used = ( ! empty( $options['general']['shortcode'] ) ) ? $options['general']['shortcode'] : 'amazon';

		// array of custom shortcodes requiring the fix
		$block = join( '|', array( $shortcode_used ) );

		// opening tag
		$rep = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", '[$2$3]', $content );

		// closing tag
		$rep = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", '[/$2]', $rep );

		return $rep;
	}

	return $content;
}
add_filter( 'the_content', 'aawp_maybe_cleanup_shortcode_output', 99 );

/**
 * Handle API Response Validation Error
 *
 * Expecting $error['Code'] and $error['Message']
 *
 * @param $error
 */
function aawp_api_response_validation_error( $error ) {

	if ( empty( $error['Code'] ) ) {
		return;
	}

	// Don't fire when API request limit was reached
	if ( 'RequestThrottled' === $error['Code'] ) {
		return;
	}

	$api_options = aawp_get_options( 'api' );

	if ( isset( $api_options['status'] ) && '1' == $api_options['status'] ) {

		// Reset status and set error
		$api_options['status'] = 0;
		$api_options['error']  = $error['Code'];

		// Store to database
		aawp_update_options( 'api', $api_options );

		// Add Log
		aawp_log( 'Amazon API', sprintf( __( 'Disconnected from Amazon API: <code>%s</code>', 'aawp' ), aawp_get_api_error_message( $error['Code'] ) . ' ( Code: ' . $error['Code'] . ')' ) );

		// Try re-verifying later
		as_schedule_single_action( time() + 3600, 'aawp_single_verify_api_credentials_event' );
	}
}

/**
 * Set country cookie in case it's not already set, & geolocation or country tracking in clicks is enabled.
 *
 * @since 3.30.8
 */
function aawp_maybe_set_country_cookie() {

	/**
	 * Check if we're in a cron job in which case don't set a cookie.
	 *
	 * @see https://github.com/fdmedia-io/aawp/issues/836
	 *
	 * @since 3.31.0
	 */
	if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
		return;
	}

	/**
	 * Do not set cookie if header is already sent. The init hook will get called several times,
	 * so only at the moment where the header isn't sent it will set the cookie.
	 * If it runs later (after the header was set) it won't set a cookie.
	 *
	 * @since 3.31.0
	 */
	if ( headers_sent() ) {
		return;
	}

	if ( is_aawp_cookie_eligible() && ! isset( $_COOKIE['aawp-country'] ) ) {

		$ip = ! empty( $_SERVER['REMOTE_ADDR'] ) ? wp_unslash( $_SERVER['REMOTE_ADDR'] ) : '';
		$ip = rest_is_ip_address( $ip ) ? wp_privacy_anonymize_ip( $ip ) : '';

		$api_url      = 'https://ipinfo.io/' . $ip . '/json/';
		$response     = wp_remote_get( $api_url );
		$api_response = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( ! empty( $api_response['country'] ) ) {
			$country = $api_response['country'];
		} else {
			$api_url      = 'https://tools.keycdn.com/geo.json?host=' . $ip;
			$response     = wp_remote_get(
				$api_url,
				array(
					'headers' => array(
						'User-Agent' => 'keycdn-tools:' . site_url(),
					),
				)
			);
			$api_response = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( ! empty( $api_response['data']['geo']['country_code'] ) ) {
				$country = $api_response['data']['geo']['country_code'];
			} else {

				$api_url      = 'https://ipapi.co/' . $ip . '/json/';
				$response     = wp_remote_get( $api_url );
				$api_response = json_decode( wp_remote_retrieve_body( $response ), true );

				if ( ! empty( $api_response['country'] ) ) {
					$country = $api_response['country'];
				} else {
					$api_url      = 'https://geolocation-db.com/json/' . $ip;
					$response     = wp_remote_get( $api_url );
					$api_response = json_decode( wp_remote_retrieve_body( $response ), true );

					if ( ! empty( $api_response['country_code'] ) ) {
						$country = $api_response['country_code'];
					}
				}
			}
		}

		if ( ! empty( $country ) ) {
			setcookie( 'aawp-country', $country, time() + ( 86400 * 30 ), '/' ); // 30 days.
		}
	}
}
add_action( 'init', 'aawp_maybe_set_country_cookie' );
