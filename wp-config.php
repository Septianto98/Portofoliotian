<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'db_portofoliotian' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '^<zVZ@Y+<w>FuGDor%-H*#[ooRbRh8KjNJi3~N8D8!BUUmD<B7=DMAO;B&*3-ql0' );
define( 'SECURE_AUTH_KEY',  'nVC#*gEZBXmJ5{1l.FunMWKwg5_:/$|R!wyA x&M8KHGw;,Q6dmmw>p Jr3=4st~' );
define( 'LOGGED_IN_KEY',    '6fzF]p_jc#[r`29Eb)z5X}}A9j=jC`/eY!~.0$a#a0j8Wn{s;gwGT_zlj_Ic<~>(' );
define( 'NONCE_KEY',        'ylLHlT>gq&>?*hA(>Golh7~ZVW^#x;bqN3i78ETwmB559qB%O)KI^W`o_05g|%_d' );
define( 'AUTH_SALT',        'U,?.SPyQ[u:Yzat_o?xyA<98Y//*JH*Uu9&/IHeEg$O,tfh9YuB|K`RV?sbz2p|9' );
define( 'SECURE_AUTH_SALT', 'd{vL (|~MI6f4 u^W0|RP3IYkLh>dhg/?<aFj)-zHV,Kl33&YYusTc$92)pXJIIF' );
define( 'LOGGED_IN_SALT',   '7uzA^@X~-(.LDV|JncztQSJXu>)o)(Syv]&CKG?biDlPe+Zylg(`iBy-WY,D35Q%' );
define( 'NONCE_SALT',       'kMW|*GtnQJa2:R_l$S(T[m$IfQw9&a:T*|vL>iS,r,@~(@(~P.@p*tXz2] rj;a ' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
