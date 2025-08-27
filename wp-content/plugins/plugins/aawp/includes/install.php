<?php
/**
 * Installation
 *
 * @since       3.3.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

function aawp_run_install() {

    /**
     * Create database tables
     */
    $AAWP_DB_Products = new AAWP_DB_Products();

    if ( ! $AAWP_DB_Products->installed() )
        $AAWP_DB_Products->create_table();

    $AAWP_DB_Lists = new AAWP_DB_Lists();

    if ( ! $AAWP_DB_Lists->installed() )
        $AAWP_DB_Lists->create_table();
}