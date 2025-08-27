<?php

namespace AAWP\Admin\Tools;

/**
 * Tools - Migrations Page.
 *
 * @since 3.32.0
 */
class Migrations {

	/**
	 * Render Migrations Page.
	 *
	 * @since 3.32.0
	 */
	public function render_page() {

		$site_stripe_migration = array(
			'heading'       => __( 'Site Stripe Migration', 'aawp' ),
			'tagline'       => __( 'This tool migrate all site stripe links (Image, Text + Image) to AAWP equivalent shortcodes.', 'aawp' ),
			'value'         => 'sitestripe_migration',
			'submit_button' => __( 'Migrate', 'aawp' ),
		);

		( new General() )->output_card( $site_stripe_migration );
	}

	/**
	 * Process the Site Stripe migration.
	 *
	 * @since 3.32.0
	 */
	public function process_site_stripe_migration() {

		global $wpdb;

		$this->aawp_set_time_limit();
		// @todo:: process in batch, instead.

		/**
		 * Get all posts containing Amazon links. We're not finding the exact Site Stripe links because using REGEX
		 * in SQL queries can have performance implications. We'll later only update posts with Site Stripe links or iframes.
		 */
		$posts = $wpdb->get_results( //phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$wpdb->prepare(
				"SELECT ID, post_content FROM {$wpdb->posts} WHERE post_type IN (%s, %s) AND post_content LIKE %s",
				'post',
				'page',
				'%' . $wpdb->esc_like( 'amazon' ) . '%'
			),
			ARRAY_A
		);

		// Loop through each post.
		foreach ( $posts as $post ) {

			// Get updated content or false if Site Stripe Links not found.
			$replaced_ss_content = $this->replace_site_stripe_links( $post['post_content'] );

			// If Site Stripe links doesn't exit, use post content else use replaced content.
			$replaced_ss_iframe_content = false === (bool) $replaced_ss_content ? $this->replace_site_stripe_iframes( $post['post_content'] ) : $this->replace_site_stripe_iframes( $replaced_ss_content );

			// Only update the post if only the post content is changed.
			if ( ! empty( $replaced_ss_content ) || ! empty( $replaced_ss_iframe_content ) ) {

				$updated_post = array(
					'ID'           => $post['ID'],
					'post_content' => ! empty( $replaced_ss_iframe_content ) ? $replaced_ss_iframe_content : $replaced_ss_content,
				);

				// Update the post.
				$result = wp_update_post( $updated_post );

				if ( $result !== 0 ) {
					aawp_log( 'Site Stripe Migration', sprintf( __( 'Migration completed for Post # %d', 'aawp' ), $post['ID'] ) );
				}
			}
		}

		// Get all widgets containing Amazon links.
		$widgets = $wpdb->get_results( //phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery
			$wpdb->prepare(
				"SELECT option_id, option_value FROM {$wpdb->options} WHERE option_value LIKE %s AND option_name LIKE %s",
				'%' . $wpdb->esc_like( 'amazon' ) . '%',
				'%widget_%'
			),
			ARRAY_A
		);

		// Loop through each widget and perform the replacement.
		foreach ( $widgets as $widget ) {

			$replaced_ss_content        = $this->replace_site_stripe_links( $widget['option_value'] );
			$replaced_ss_iframe_content = false === (bool) $replaced_ss_content ? $this->replace_site_stripe_iframes( $widget['option_value'] ) : $this->replace_site_stripe_iframes( $replaced_ss_content );

			if ( ! empty( $replaced_ss_content ) || ! empty( $replaced_ss_iframe_content ) ) {
				// Update the widget content in the database.
				$wpdb->update( //phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery
					$wpdb->options,
					array( 'post_content' => ! empty( $replaced_ss_iframe_content ) ? $replaced_ss_iframe_content : $replaced_ss_content ),
					array( 'option_id' => $widget['option_id'] )
				);

				aawp_log( 'Site Stripe Migration', sprintf( __( 'Migration completed for Widget # %d', 'aawp' ), $widget['option_id'] ) );
			}
		}
	}

	/**
	 * Replace site Stripe Links in the provided content with AAWP field shortcode [amazon fields="ASIN" value="thumb"].
	 *
	 * @param string $content The content to replace.
	 *
	 * @since 3.32.0
	 *
	 * @return bool|string The updated content if Site Stripe Links are found or false.
	 */
	public function replace_site_stripe_links( $content ) {

		$pattern = '/<a\s[^>]*href=[\'"]?(https:\/\/www\.amazon\.[^\s\'"]+)[\'"]?[^>]*>(.*?)<img\s[^>]*><\/a><img\s[^>]*>(?!<\/a>)/i';

		// Use a regular expression to find Amazon links.
		preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER );

		// The content doesn't contain Site Stripe links.
		if ( empty( $matches ) ) {
			return false;
		}

		// Loop through the matches and replace the entire <a> tag with the shortcode.
		foreach ( $matches as $match ) {
			$amazon_link = $match[1];

			// Check if required parameters exist in the link.
			if (
				strpos( $amazon_link, 'linkCode=' ) !== false &&
				strpos( $amazon_link, 'tag=' ) !== false &&
				strpos( $amazon_link, 'linkId=' ) !== false
			) {
				// Extract ASIN or relevant identifier based on your structure.
				preg_match( '/\/dp\/([A-Z0-9]+)/', $amazon_link, $asin_matches );

				if ( ! empty( $asin_matches[1] ) ) {
					$asin = $asin_matches[1];

					aawp_log( 'Site Stripe Migration', sprintf( __( 'Migrating ASIN <code>%s</code>', 'aawp' ), $asin ) );

					$shortcode = '[amazon fields="' . $asin . '" value="thumb"]';

					// Replace the entire <a> tag with the shortcode.
					$content = str_replace( $match[0], $shortcode, $content );
				}
			}
		}

		return $content;
	}

	/**
	 * Replace site Stripe iframes with the AAWP box shortcode.
	 *
	 * @param string $content The content to replace the iframes with the AAWP box shortcode.
	 *
	 * @since 3.32.0
	 *
	 * @return bool|string The updated content if Site Stripe iframes are found or false.
	 */
	public function replace_site_stripe_iframes( $content ) {

		$pattern = '/<iframe\s[^>]*src=[\'"]?(\/\/[^\s\'"]*amazon[^\s\'"]+)[\'"]?[^>]*><\/iframe>/i';

		// Use a regular expression to find Amazon iframes.
		preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER );

		if ( empty( $matches ) ) {
			return false;
		}

		// Loop through the matches and replace the iframes with shortcodes.
		foreach ( $matches as $match ) {

			$amazon_src = $match[1];

			// Check if the src contains "amazon".
			if ( strpos( $amazon_src, 'amazon' ) !== false ) {
				// Extract ASIN or relevant identifier based on your structure.
				preg_match( '/placement=([A-Z0-9]+)/', $amazon_src, $asin_matches );

				if ( ! empty( $asin_matches[1] ) ) {
					$asin = $asin_matches[1];

					aawp_log( 'Site Stripe Migration', sprintf( __( 'Migrating ASIN <code>%s</code>', 'aawp' ), $asin ) );

					$shortcode = '[amazon box="' . $asin . '"]';

					// Replace the iframe with the shortcode.
					$content = str_replace( $match[0], $shortcode, $content );
				}
			}
		}

		return $content;
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
}
