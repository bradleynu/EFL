<?php
/**
 * Uninstall
 *
 * Deletes all the plugin data i.e.
 * 		1. Plugin options.
 * 		2. Database tables.
 *      3. Events
 *
 * @since       3.3.0
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

if ( empty( get_option( 'aawp_tools' )['uninstall_aawp'] ) ) {
    return;
}

/*
 * Delete plugin options
 */
delete_option( 'aawp_licensing' );
delete_option( 'aawp_api' );
delete_option( 'aawp_general' );
delete_option( 'aawp_output' );
delete_option( 'aawp_functions' );
delete_option( 'aawp_support' );
delete_option( 'aawp_tools' );

/*
 * Delete old database tables
 */
global $wpdb;

$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "aawp_products" );
$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "aawp_lists" );
$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "aawp_bitly_links" );
$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "aawp_logs" );
$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "aawp_clicks" );

delete_option( $wpdb->prefix . "aawp_products_db_version" );
delete_option( $wpdb->prefix . "aawp_lists_db_version" );
delete_option( $wpdb->prefix . "aawp_bitly_links_db_version" );
delete_option( $wpdb->prefix . "aawp_bitly_link_creation_failed_msg" );
delete_option( $wpdb->prefix . "aawp_logs_settings" );
delete_option( $wpdb->prefix . "aawp_clicks_settings" );

/**
 * Delete AAWP Products API options.
 */
$wpdb->query( "DELETE FROM `" . $wpdb->prefix . "options` WHERE `option_name` LIKE ('aawp_products_api_%')" );

/*
 * Delete transients
 */
$wpdb->query( "DELETE FROM `" . $wpdb->prefix . "options` WHERE `option_name` LIKE ('_transient_aawp_%')" );

/**
 * Remove Scheduled Actions.
 *
 * @since 3.21.0
 */
( new \AAWP\BackgroundTasks() )->cancel_all();