<?php
/**
 * Background tasks performed via Action Scheduler. All the tasks can be found in Tools > Scheduled Actions.
 * Some of the background tasks aren't here but within their modules. "logs clear", "usage data", and "notifications update" tasks.
 *
 * @since 3.21.0
 */

namespace AAWP;

/**
 * The BackgroundTasks Class.
 *
 * @since 3.21.0
 */
class BackgroundTasks {

	/**
	 * Initialize background tasks.
	 *
	 * @since 3.21.0
	 */
	public function init() {

		// Disable if CRON is disabled.
		if ( ! empty( get_option( 'aawp_tools' )['deactivate_as'] ) ) {
			return;
		}

		add_action( 'admin_init', [ $this, 'schedule' ] );
		add_action( 'aawp_execute_database_garbage_collection', 'aawp_execute_database_garbage_collection' );
		add_action( 'aawp_delete_product_images_cache', 'aawp_delete_product_images_cache' );
		add_action( 'aawp_execute_products_lists_renew_cache', 'aawp_execute_renew_cache' );
		add_action( 'aawp_execute_rating_renew_cache', 'aawp_renew_rating_cache_event' );
		add_action( 'aawp_execute_single_renew_cache_event', [ $this, 'renew_cache' ] );
		add_action( 'aawp_single_verify_api_credentials_event', 'aawp_maybe_verify_stored_api_credentials' );
		add_action( 'aawp_process_site_stripe_migration', [ $this, 'process_site_stripe_migration' ] );
	}

	/**
	 * Schedule the tasks.
	 *
	 * @since 3.21.0
	 */
	public function schedule() {

		// Database Garbase Collection.
		if ( empty( aawp_get_option( 'disable_database_garbage_collection', 'general' ) ) && false === as_next_scheduled_action( 'aawp_execute_database_garbage_collection' ) ) {
			as_schedule_recurring_action( strtotime( '+1 hour' ), HOUR_IN_SECONDS, 'aawp_execute_database_garbage_collection', [], 'aawp' );
		}

		// Product local image cache.
		if ( aawp_is_product_local_images_enabled() && false === as_next_scheduled_action( 'aawp_delete_product_images_cache' ) ) {
			as_schedule_recurring_action( strtotime( '+1 day' ), DAY_IN_SECONDS, 'aawp_delete_product_images_cache', [], 'aawp' );
		}

		// Products & lists renew.
		if ( false === as_next_scheduled_action( 'aawp_execute_products_lists_renew_cache' ) ) {
			as_schedule_recurring_action( time(), MINUTE_IN_SECONDS * 5, 'aawp_execute_products_lists_renew_cache', [], 'aawp' );
		}

		// Ratings Renew.
		if ( false === as_next_scheduled_action( 'aawp_execute_rating_renew_cache' ) ) {
			as_schedule_recurring_action( time(), MINUTE_IN_SECONDS * 5, 'aawp_execute_rating_renew_cache', [], 'aawp' );
		}
	}

	/**
	 * Renew Products & Rating Cache.
	 * Runs on single event, once the "Renew Cache" button is clicked. aawp_renew_cache() function schedules a single event
	 * which runs this method.
	 *
	 * @since 3.21.0
	 */
	public function renew_cache() {

		// Renew Products & Lists.
		aawp_execute_renew_cache( true );

		// Renew Ratings.
		aawp_renew_rating_cache_event();
	}

	/**
	 * Process site stripe migration task.
	 *
	 * @since 3.40.1
	 */
	public function process_site_stripe_migration() {
		( new Admin\Tools\Migrations() )->process_site_stripe_migration();
	}

	/**
	 * Cancel all the AS actions for a group "aawp".
	 *
	 * @since 3.21.0
	 *
	 * @param string $group Group to cancel all actions for.
	 */
	public function cancel_all() {

		if ( class_exists( 'ActionScheduler_DBStore' ) ) {
			\ActionScheduler_DBStore::instance()->cancel_actions_by_group( 'aawp' );
		}
	}
}
