<?php
/**
 * Scripts
 *
 * @since       1.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Load admin scripts
 *
 * @since       3.2.0
 */
function aawp_admin_scripts() {

    global $current_screen;

    // Load dependencies.
    wp_enqueue_style( 'wp-color-picker' );

    // Additional condition to only load jquery-confirm on settings page.
    if ( isset( $current_screen ) && isset( $current_screen->base ) && 'aawp_page_aawp-settings' === $current_screen->base ) {
        wp_enqueue_script( 'jquery-confirm', AAWP_PLUGIN_URL . 'assets/dist/jquery-confirm/jquery-confirm.min.js', array( 'jquery' ), '3.3.4' );
        wp_enqueue_style( 'jquery-confirm', AAWP_PLUGIN_URL . 'assets/dist/jquery-confirm/jquery-confirm.min.css', false, '3.3.4' );
    }

    // Load scripts.
    wp_enqueue_script( 'aawp-admin', AAWP_PLUGIN_URL . 'assets/dist/js/admin.js', array( 'jquery', 'jquery-ui-sortable', 'wp-color-picker' ), AAWP_VERSION );
    wp_enqueue_style( 'aawp-admin', AAWP_PLUGIN_URL . 'assets/dist/css/admin.css', false, AAWP_VERSION );

    // Prepare ajax.
    wp_localize_script( 'aawp-admin', 'aawp_post', array(
        'ajax_url'          => admin_url( 'admin-ajax.php' ),
        'admin_nonce'       => wp_create_nonce( 'aawp-admin-nonce' ),
        'confirm_title'     => esc_html__( 'Heads up!', 'aawp'),
        'confirm_content'   => esc_html__( 'AAWP API has limited features and should only be used if you don\'t have access to Amazon API. Do you want to continue?', 'aawp' ),
        'confirm_text'      => esc_html__( 'Yes, continue', 'aawp' ),
        'cancel_text'       => esc_html__( 'Cancel', 'aawp' ),
    ));
}
add_action( 'aawp_load_admin_scripts', 'aawp_admin_scripts' );

/**
 * Load frontend scripts
 *
 * @since       3.2.0
 */
function aawp_scripts() {

    global $post;

    // Register styles.
    wp_register_style( 'aawp', AAWP_PLUGIN_URL . 'assets/dist/css/main.css', false, AAWP_VERSION );

    // Don't register javascript on AMP endpoints.
    if ( aawp_is_amp_endpoint() )
        return;

    // Register scripts.
    wp_register_script( 'aawp', AAWP_PLUGIN_URL . 'assets/dist/js/main.js', array( 'jquery' ), AAWP_VERSION, true );

    // Enqueue assets now if load assets globally is enabled. Else the assets are enqueued at the time of shortcode render.
    if ( ! empty( aawp_get_option( 'load_assets_globally', 'output' ) ) ) {
        wp_enqueue_style( 'aawp' );
        wp_enqueue_script( 'aawp' );
    }

    // Enqueue style early in the head by checking the content on singular pages.
    if (
        is_singular() && is_a( $post, 'WP_Post' ) &&
        (
            has_shortcode( $post->post_content, 'aawp' ) ||
            has_shortcode( $post->post_content, 'amazon' ) ||
            ( function_exists( 'has_block' ) && has_block( 'aawp/aawp-block' ) )
        )
    ) {
        wp_enqueue_style( 'aawp' );
    }
}
add_action( 'aawp_load_scripts', 'aawp_scripts' );

