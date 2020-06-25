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
define( 'DB_NAME', 'portfolio' );

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
define( 'AUTH_KEY',         '+&l]Oz{71bX$e4q~bY_x]YZV2al$/FzZNh7{q|Tj-drtp;lV$QX%l8a&DXwYDj1#' );
define( 'SECURE_AUTH_KEY',  ',B{6B2&@dq7<H_hCb>RkjhZ)[77, *Kv Nw A>$u&0ViPzPdo`/;b7Y_ST8327:I' );
define( 'LOGGED_IN_KEY',    'aFJ>n8!X2Bm@^e=rOA5y(BhNb5zPyo}`D`|b z[LJ#[HxckgV1?}-FQR2 ,OTt#O' );
define( 'NONCE_KEY',        '0pOXxvV6CLDP?c]cIT&;u2/D.6*YaE<@N(#Y^Lb~4G2NBhQs]3$rFrMU1<(*-3i+' );
define( 'AUTH_SALT',        '6p<(`&l9sX`d#L,{E?<5n8Btrv@V aAajIXb;>uSK@C,14be83(S_*=oJD#0RQr8' );
define( 'SECURE_AUTH_SALT', '`Opb{:v_AatS_m6T86WYY0V8;5r`XP#}e7A4~tYA.*by/tgaNj?ffs/p$|{?02|p' );
define( 'LOGGED_IN_SALT',   '{-Y#N]Oi f-Ky-XX8WY&SRalF.;1hQ!h0%Z>%xKlQOYx<=4wB;f,_KK5+,AA*L.]' );
define( 'NONCE_SALT',       ' 9P00[XKUXh5Ui`PY,n[dZy_<O8ct%Ikk{4L2PYY(b?is_l~_H#E#NG?R@#$W-4j' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'clk_3c54da0c8b_wp_';

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
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
