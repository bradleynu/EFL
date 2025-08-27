<?php
/**
 * Amazon API functions
 *
 * @package     AAWP
 * @since       3.4.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Get list from API
 *
 * @param array $args
 *
 * @return array|bool|null
 */
function aawp_get_list_from_api( $args = array() ) {

    $list = aawp()->api->get_list( $args );

    return $list;
}

/**
 * Get product from API
 *
 * @param $asin
 * @param array $args
 *
 * @return bool
 */
function aawp_get_product_from_api( $asin, $args = array() ) {

    $product = aawp()->api->get_product( $asin, $args );

    return $product;
}

/**
 * Get products from API
 *
 * @param array $args
 *
 * @return bool
 */
function aawp_get_products_from_api( $asins = array(), $args = array() ) {

    $products = aawp()->api->get_products( $asins, $args );

    return $products;
}

/**
 * Handle API product error response
 *
 * @param string $asin
 * @param array $error Expecting keys "code" and "message".
 */
function aawp_handle_api_product_error_response( $asin, $error ) {

    if ( is_array( $asin ) ) {
        $asin = implode( ',', $asin );
    }

    $log_text = 'API Response Error <br/> ASIN: <code>' . $asin . '</code> <br/> Code: ' . $error['code'] . '<br/> Message: ' . $error['message'];

    //aawp_debug_display( $log_text );
    aawp_log( 'Amazon API (Product)', $log_text );

    if ( in_array( $error['code'], [ 'InvalidParameterValue', 'ItemNotAccessible' ], true ) ) {

        aawp_update_product_status_by_asin( $asin, 'invalid' );
    }

    return;
}