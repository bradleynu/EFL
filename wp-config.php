<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// * Database settings - You can get this info from your web host * //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/*#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '5(  xB{^3:kQw#3]*!Nf.h_6&Ggrf*fnke&,w+&O1ln[S0Cc;$jbH3Q|k,FexR~^' );
define( 'SECURE_AUTH_KEY',   'Ji7eGWYi4ypT[ #h3m5z(7j$!ywsmjH[-p#$dt=2*QMAZGSHX<]#CeeEOBR85PC9' );
define( 'LOGGED_IN_KEY',     'VIIgFRW6k^yJIGkUv4]da3<hfWJ%IZ^RisHNSHeBhWtm~?JnkG,$V&fQ8ydu{(u7' );
define( 'NONCE_KEY',         '9*u*^S+vn3^)0hVkfx[.Z_|JI !*c{F:j#rK`T@NZ$sFT]h$WW1OP =Znf>KMv]H' );
define( 'AUTH_SALT',         '-KT,|%9-ryFMj;=)8BP!9HLZ79g:,CcL]R5DVNAXN4WOjwozPuhcc-`9)20 +_.}' );
define( 'SECURE_AUTH_SALT',  ']IU)5MW29<RSApi9rOV9At`awQ8GApQhCVX46fH+f!{{SS46:Q&{H~GhbrA_<A+3' );
define( 'LOGGED_IN_SALT',    '.-0mOc;]}9N2&L[h6or*Ou~C;b [pn%EAAEVP(lcs8+ ?`6z,L).]yqDH*Z>7?' );
define( 'NONCE_SALT',        '{:qw.]BLyj@5oE{|+;Y&uMu8f|+W(;(HZR$/<k>k,*w6Q:gwymv9T2bh_i-;SaHa' );
define( 'WP_CACHE_KEY_SALT', 'E2p:ZvPzdnsH/512R/>Ew.(L)zQKaUF;mv-n}by0,XJPAVz[uNsb2B%U*3gGZT' );


/*#@-/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */



define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', DIR . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';