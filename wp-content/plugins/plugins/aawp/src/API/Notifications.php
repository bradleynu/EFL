<?php

namespace AAWP\API;

/**
 * Notifications.
 *
 * @since 3.20
 */
class Notifications {

	/**
	 * Source of notifications content.
	 *
	 * @since 3.20
	 *
	 * @var string
	 */
	private $endpoint = 'https://api.getaawp.com/v1/get/notifications';

	/**
	 * Component.
	 *
	 * @since 3.20
	 *
	 * @var string
	 */
	private $component = 'AAWP Notifications API';

	/**
	 * Option value.
	 *
	 * @since 3.20
	 *
	 * @var bool|array
	 */
	public $option = false;

	/**
	 * Initialize Notifications.
	 *
	 * @since 3.20
	 */
	public function init() {

		// Provide an ability to hide notification announcements.
		if ( ! apply_filters( 'aawp_admin_notifications_enable', true ) ) {
			return;
		}

		if ( defined( 'AAWP_API_URL' ) ) {
			$this->endpoint = AAWP_API_URL . '/get/notifications';
		}

		add_action( 'in_admin_header', [ $this, 'output' ], PHP_INT_MAX );
		add_action( 'wp_ajax_aawp_notification_dismiss', [ $this, 'dismiss' ] );
		add_action( 'aawp_admin_notifications_update', [ $this, 'update' ] );
		add_action( 'admin_init', [ $this, 'schedule' ] );
		add_action( 'admin_init', [ $this, 'usage_notice' ] );
		add_action( 'admin_init', [ $this, 'maybe_add_api_usage_quota_notice' ] );
	}

	/**
	 * Schedule a notification fetching task to run daily.
	 *
	 * @since 3.20
	 */
	public function schedule() {

		$option = $this->get_option();

		// If the notifications isn't updated yet, run the update immediately.
		if ( empty( $option['update'] ) ) {
			$this->update();
		}

		// Schedule notifications.
		if ( false === as_next_scheduled_action( 'aawp_admin_notifications_update' ) ) {
			as_schedule_recurring_action( strtotime( '+ 1 day' ), DAY_IN_SECONDS, 'aawp_admin_notifications_update', [], 'aawp' );
		}
	}

	/**
	 * Get notification data.
	 *
	 * @since 3.20
	 *
	 * @return array
	 */
	public function get() {

		$option = $this->get_option();
		$events = ! empty( $option['events'] ) ? $this->verify_active( $option['events'] ) : [];
		$feed   = ! empty( $option['feed'] ) ? $this->verify_active( $option['feed'] ) : [];

		return array_merge( $events, $feed );
	}

	/**
	 * Add a manual notification event.
	 *
	 * @since 3.20
	 *
	 * @param array $notification Notification data.
	 */
	public function add( $notification ) {

		if ( empty( $notification['id'] ) ) {
			return;
		}

		$option = $this->get_option();

		if ( in_array( $notification['id'], $option['dismissed'] ) ) { // phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
			return;
		}

		foreach ( $option['events'] as $item ) {
			if ( $item['id'] === $notification['id'] ) {
				return;
			}
		}

		$notification = $this->verify( [ $notification ] );

		update_option(
			'aawp_notifications',
			[
				'update'    => $option['update'],
				'feed'      => $option['feed'],
				'events'    => array_merge( $notification, $option['events'] ),
				'dismissed' => $option['dismissed'],
			]
		);
	}

	/**
	 * Update notification data from feed.
	 *
	 * @since 3.20
	 */
	public function update() {

		$feed   = $this->fetch_feed();
		$option = $this->get_option();

		update_option(
			'aawp_notifications',
			[
				'update'    => time(),
				'feed'      => $feed,
				'events'    => $option['events'],
				'dismissed' => $option['dismissed'],
			]
		);
	}

	/**
	 * Fetch notifications from feed.
	 *
	 * @since 3.20
	 *
	 * @return array
	 */
	public function fetch_feed() {

		$response = wp_remote_get( $this->endpoint );

		if ( is_wp_error( $response ) ) {
			aawp_log( $this->component, '<code>' . print_r( $response->get_error_message(), true ) . '</code>' ); //phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
			return [];
		}

		$body = wp_remote_retrieve_body( $response );

		if ( empty( $body ) ) {
			aawp_log( $this->component, esc_html__( 'Empty response body!', 'aawp' ) ); //phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
			return [];
		}

		if ( ! empty( $response['response']['code'] ) && ! empty( $response['response']['message'] ) && $response['response']['code'] != '200' ) { //phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison, WordPress.PHP.YodaConditions.NotYoda

			aawp_log( $this->component, '<code>' . $response['response']['code'] . '</code>' . $response['response']['message'] );
			return [];
		}

		aawp_log( $this->component, esc_html__( 'Fetched Notifications Feed!', 'aawp' ) );

		return $this->verify( json_decode( $body, true ) );
	}

	/**
	 * Verify notification data before it is saved.
	 *
	 * @since 3.20
	 *
	 * @param array $notifications Array of notifications items to verify.
	 *
	 * @return array
	 */
	public function verify( $notifications ) { // phpcs:ignore Generic.Metrics.CyclomaticComplexity.TooHigh

		$data   = [];
		$option = get_option( 'aawp_notifications', [] );

		if ( ! is_array( $notifications ) || empty( $notifications ) ) {
			return $data;
		}

		foreach ( $notifications as $notification ) {

			// The message should never be empty, if they are, ignore.
			if ( empty( $notification['title'] ) ) {
				continue;
			}

			// Ignore if expired.
			if ( ! empty( $notification['end_date'] ) && time() > strtotime( $notification['end_date'] ) ) {
				continue;
			}

			// Ignore if notification has already been dismissed.
			if ( ! empty( $option['dismissed'] ) && in_array( $notification['id'], $option['dismissed'] ) ) { // phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict
				continue;
			}

			$data[] = $notification;
		}//end foreach

		return $data;
	}

	/**
	 * Get option value.
	 *
	 * @since 3.20
	 *
	 * @param bool $cache Reference property cache if available.
	 *
	 * @return array
	 */
	public function get_option( $cache = true ) {

		if ( $this->option && $cache ) {
			return $this->option;
		}

		$option = get_option( 'aawp_notifications', [] );

		$this->option = [
			'update'    => ! empty( $option['update'] ) ? $option['update'] : 0,
			'events'    => ! empty( $option['events'] ) ? $option['events'] : [],
			'feed'      => ! empty( $option['feed'] ) ? $option['feed'] : [],
			'dismissed' => ! empty( $option['dismissed'] ) ? $option['dismissed'] : [],
		];

		return $this->option;
	}

	/**
	 * Verify saved notification data for active notifications.
	 *
	 * @since 3.20
	 *
	 * @param array $notifications Array of notifications items to verify.
	 *
	 * @return array
	 */
	public function verify_active( $notifications ) {

		if ( ! is_array( $notifications ) || empty( $notifications ) ) {
			return [];
		}

		// Remove notfications that are not active.
		foreach ( $notifications as $key => $notification ) {

			if (
				( ! empty( $notification['start_date'] ) && time() < strtotime( $notification['start_date'] ) ) ||
				( ! empty( $notification['end_date'] ) && time() > strtotime( $notification['end_date'] ) )
			) {
				unset( $notifications[ $key ] );
			}
		}

		return $notifications;
	}

	/**
	 * Update dismiss data to database.
	 *
	 * @since 3.20.
	 */
	public function dismiss() {

		check_admin_referer( 'aawp-admin-nonce', 'security' );

		if ( empty( $_POST['id'] ) ) {
			wp_send_json_error();
		}

		$id     = sanitize_text_field( wp_unslash( $_POST['id'] ) );
		$option = $this->get_option();
		$type   = is_numeric( $id ) ? 'feed' : 'events';

		$option['dismissed'][] = $id;
		$option['dismissed']   = array_unique( $option['dismissed'] );

		// Remove notification.
		if ( is_array( $option[ $type ] ) && ! empty( $option[ $type ] ) ) {
			foreach ( $option[ $type ] as $key => $notification ) {
				if ( (string) $notification['id'] === (string) $id ) {
					unset( $option[ $type ][ $key ] );
					break;
				}
			}
		}

		// Update the usage optin.
		if ( ! empty( $_POST['countMeIn'] ) ) {
			$general                = get_option( 'aawp_general' );
			$general['usage_optin'] = 1;
			update_option( 'aawp_general', $general );
		}

		update_option( 'aawp_notifications', $option );

		wp_send_json_success();
	}

	/**
	 * Output the notification on AAWP Pages.
	 *
	 * @since 3.20
	 */
	public function output() { // phpcs:ignore Generic.Metrics.CyclomaticComplexity.TooHigh

		// Display the notification only on AAWP pages.
		if ( ! \AAWP\Admin\Menu::is_aawp_page() ) { // phpcs:ignore
			return;
		}

		$notifications = $this->get();

		if ( empty( $notifications ) ) {
			return;
		}

		$notifications_html   = '';
		$current_class        = ' current';
		$content_allowed_tags = [
			'em'     => [],
			'strong' => [],
			'span'   => [
				'style' => [],
			],
			'a'      => [
				'href'   => [],
				'target' => [],
				'rel'    => [],
			],
			'br' => []
		];

		foreach ( $notifications as $notification ) {

			if ( is_int( $notification['id'] ) ) { // Only the notifications from feed. Events notifications should have string ID.
				$notification = $this->notification_in_lang( $notification );
			}

			// Buttons HTML.
			$buttons_html = '';

			$buttons_html .= sprintf(
				'<a href="%1$s?utm_source=%5$s&utm_medium=button&utm_campaign=admin+notifications&utm_term=%6$s" class="button button-%2$s"%3$s>%4$s</a>',
				! empty( $notification['link'] ) ? esc_url( $notification['link'] ) : '',
				'primary', // phpcs:ignore WordPress.PHP.YodaConditions.NotYoda
				'target="_blank" rel="noopener noreferrer"', // phpcs:ignore WordPress.PHP.YodaConditions.NotYoda
				! empty( $notification['button_label'] ) ? sanitize_text_field( $notification['button_label'] ) : esc_html__( 'Read More', 'aawp' ),
				site_url(),
				esc_html( $notification['title'] )
			);

			$buttons_html = ! empty( $buttons_html ) ? '<div class="aawp-notifications-buttons">' . $buttons_html . '</div>' : '';

			// It's usage tracking notice.
			if ( 'usage' === $notification['id'] ) {
				$buttons_html  = '<div class="aawp-notifications-buttons usage-optin">';
				$buttons_html .= '<a href="#" class="button button-primary usage-optin-no">' . __( 'No, I don\'t want to help', 'aawp' ) . '</a>';
				$buttons_html .= '<a href="#" value="count-me-in" class="button button-secondary usage-optin-yes">' . __( 'Yes, I would like to help &hearts;', 'aawp' ) . '</a>';
				$buttons_html .= '</div>';
			}

			if ( 'aawp_api_usage_quota_expiry' === $notification['id'] ) {
				$buttons_html  = '<div class="aawp-notifications-buttons aawp_api_usage_quota_expiry">';
				$buttons_html .= '<a href="'. esc_url( admin_url( 'admin.php?page=aawp-settings' ) ) .'" rel="noopener noreferer" class="button button-primary">' . __( 'Check Amazon API Access', 'aawp' ) . '</a>';
				$buttons_html .= '</div>';
			}

			// Notification HTML.
			$notifications_html .= sprintf(
				'<div class="aawp-notifications-message%5$s" data-message-id="%4$s">
					<p class="aawp-notifications-date">%6$s</p>
					<h3 class="aawp-notifications-title">%1$s</h3>
					<p class="aawp-notifications-description">%2$s</p>
					%3$s
				</div>',
				! empty( $notification['title'] ) ? sanitize_text_field( $notification['title'] ) : '',
				! empty( $notification['description'] ) ? wp_kses( $notification['description'], $content_allowed_tags ) : '',
				$buttons_html,
				! empty( $notification['id'] ) ? esc_attr( sanitize_text_field( $notification['id'] ) ) : 0,
				$current_class,
				! empty( $notification['start_date'] ) ? aawp_datetime( strtotime( $notification['start_date'] ) ) : ( ! empty( $notification['created_at'] ) ? aawp_datetime( strtotime( $notification['created_at'] ) ) : '' )
			);

			// Only first notification is current.
			$current_class = '';
		}//end foreach
		?>

		<div id="aawp-notifications">
			<div class="aawp-notifications-header">
				<div class="aawp-notifications-bell">
					<svg xmlns="http://www.w3.org/2000/svg" width="15" height="17" fill="none">
						<path fill="#777" d="M7.68 16.56c1.14 0 2.04-.95 2.04-2.17h-4.1c0 1.22.9 2.17 2.06 2.17Zm6.96-5.06c-.62-.71-1.81-1.76-1.81-5.26A5.32 5.32 0 0 0 8.69.97H6.65A5.32 5.32 0 0 0 2.5 6.24c0 3.5-1.2 4.55-1.81 5.26a.9.9 0 0 0-.26.72c0 .57.39 1.08 1.04 1.08h12.38c.65 0 1.04-.5 1.07-1.08 0-.24-.1-.51-.3-.72Z"/>
					</svg>
					<span class="wp-ui-notification aawp-notifications-circle"></span>
				</div>
				<div class="aawp-notifications-title"><?php esc_html_e( 'Notifications', 'aawp' ); ?></div>
			</div>

			<div class="aawp-notifications-body">
			<a class="dismiss" title="<?php echo esc_attr__( 'Dismiss this message', 'aawp' ); ?>"><i class="dashicons dashicons-dismiss" aria-hidden="true"></i></a>
				<?php if ( count( $notifications ) > 1 ) : ?>
					<div class="navigation">
						<a class="prev">
							<span class="screen-reader-text"><?php esc_attr_e( 'Previous message', 'aawp' ); ?></span>
							<span aria-hidden="true">‹</span>
						</a>
						<a class="next">
							<span class="screen-reader-text"><?php esc_attr_e( 'Next message', 'aawp' ); ?>"></span>
							<span aria-hidden="true">›</span>
						</a>
					</div>
				<?php endif; ?>

				<div class="aawp-notifications-messages">
					<?php echo $notifications_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Maybe add API usage quota expiry notice.
	 *
	 * @since 3.31.0
	 */
	public function maybe_add_api_usage_quota_notice() {

		if ( ! \AAWP\Admin\Menu::is_aawp_page() ) {
			return;
		}

		if ( empty( get_transient('aawp_products_api_error') ) || '419: Usage Quota Expired.' !== get_transient('aawp_products_api_error') ) { // @todo:: return error codes from api so we don't have to compare with error message.
			return;
		}

		$contact_us = aawp_is_lang_de() ?  'https://aawp.de/kontakt/' : 'https://getaawp.com/contact/';

		// Create a notification to add.
		$notification = [
			'id'                         => 'aawp_api_usage_quota_expiry',
			'title'                      => __( 'Attention: Your access to the AAWP API has expired.', 'aawp' ),
			'description'                => sprintf( __( 'The AAWP API is a service that we developed independently of the plugin to enable new affiliates without access to the official Amazon API to retrieve product data and use our plugin.
												The providing of this service costs a certain amount every month and therefore cannot be offered for free.<br/><br/>
												With the purchase of your AAWP license, you have received three-month access to our AAWP API. Unfortunately, this period has now expired.<br/><br/>
												If you have already earned commissions via the Amazon Associates in the last 3 months, you should already be able to use the official Amazon API. Please go to the plugin settings (tab "Amazon API") and check if you can switch to the Amazon API.
												Otherwise, <a href="'. $contact_us .'" target="_blank" rel="noopener noreferer">contact us</a> for a custom solution.
												', 'aawp' ) ),
			'button_label'               => __( 'Check Amazon API Access', 'aawp' ),
			'link'						 => esc_url( admin_url( 'admin.php?page=aawp-settings&tab=api') ),
			'start_date' => '',
			'end_date'                   => '',
			'created_at'                 => '',
			'updated_at'                 => '',
		];

		$this->add( $notification );
	}

	/**
	 * Allow Usage Tracking Notification.
	 *
	 * @since 3.22
	 */
	public function usage_notice() {

		if ( ! \AAWP\Admin\Menu::is_aawp_page() ) {
			return;
		}

		if ( ! empty( aawp_get_option( 'usage_optin', 'general' ) ) ) {

			$option = $this->option;

			// Already enabled, so remove the "Usage" event if it's already there.
			foreach ( (array) $option['events'] as $key => $event ) {
				if ( 'usage' === $event['id'] ) {

					// It's the usage event.
					unset( $option['events'][ $key ] );
					$found = true;
				}
			}

			// Bail if usage event isn't even there.
			if ( ! isset( $found ) ) {
				return;
			}

			update_option( 'aawp_notifications', $option );

			return;
		}//end if

		// Create a notification to add.
		$notification = [
			'id'                         => 'usage',
			'title'                      => __( 'Help us to improve AAWP', 'aawp' ),
			'description'                => sprintf( __( 'We hope you are enjoying using our software. As part of our commitment to continuously improve our product, we would like to invite you to opt in to share telemetry data with us. This data will help us better understand how our software is being used and identify areas for improvement. %s Please note that all data collected is anonymous and will not include any personal information. More details can be found %s', 'aawp' ), '<br/><br/>', '<a href="'. esc_url( aawp_get_page_url( 'telemetry-data' ) ) .'">' . esc_html__( 'here', 'aawp' ) . '</a>' ),
			'button_label'               => '',
			// Not here.
							'start_date' => '',
			'end_date'                   => '',
			'created_at'                 => '',
			'updated_at'                 => '',
		];

		$this->add( $notification );
	}

	/*
	 * Get the notification in site language.
	 *
	 * @param array $notification Notification Data.
	 *
	 * @since 3.22
	 */
	private function notification_in_lang( $notification ) {

		$lang = get_locale();

		if ( 'de_DE' === $lang ) {
			$notification['title']        = $notification['title_de'];
			$notification['description']  = $notification['description_de'];
			$notification['link']         = $notification['link_de'];
			$notification['button_label'] = $notification['button_label_de'];

		} elseif ( 'es_ES' === $lang ) {
			$notification['title']        = $notification['title_es'];
			$notification['description']  = $notification['description_es'];
			$notification['link']         = $notification['link_es'];
			$notification['button_label'] = $notification['button_label_es'];
		}

		return apply_filters( 'aawp_api_notification', $notification );
	}
}
