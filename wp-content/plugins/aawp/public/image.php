<?php
// Prevent search engines from indexing this script
header("X-Robots-Tag: noindex");

if ( empty( $_GET['url'] ) ) {
    die( 'URL is missing.' );
}

$encoded_url = base64_decode( $_GET['url'] );

if ( strpos( $encoded_url, '|' ) !== false ) {
    list( $encoded_image_url, $expiration_time ) = explode( '|', $encoded_url );
} else {
    die( 'Invalid image.' );
}

// Expired.
if ( $expiration_time < time() ) {
    die( 'URL is expired.' );
}

$url = base64_decode( $encoded_image_url );

// Validate URL.
if ( ! filter_var( $url, FILTER_VALIDATE_URL ) || (
    ! preg_match('/^https:\/\/images-(cn|eu|fe|na)\.ssl-images-amazon.com\/images\/I\/(?:[A-Za-z0-9\-\+\_\%]+)\.(?:[A-Za-z0-9\_]+)\.(jpg|jpeg|png)/', $url ) &&
    ! preg_match('/^https:\/\/m\.media-amazon.com\/images\/I\/(?:[A-Za-z0-9\+\-\_\.\%]+)\.(jpg|jpeg|png)/', $url ) ) ) {
    die( 'Invalid image.' );
}

// Validate file.
if ( substr_compare( $url, '.jpg', -strlen( '.jpg' ) ) === 0 || substr_compare( $url, '.jepg', -strlen( '.jepg' ) ) === 0 ) {
    header( "Content-Type: image/jpeg" );
} elseif ( substr_compare( $url, '.png', -strlen( '.png' ) ) === 0 ) {
    header( "Content-Type: image/png" );
} else {
    die( 'Invalid image.' );
}

readfile( $url );