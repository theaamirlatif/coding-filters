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
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
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
define( 'AUTH_KEY',         '-65~ _?d!u.%{*]65lO8huk[Sb#|`0Kn;BiMz_dLgY}-7_h2?9_k#T~mXomA?%g<' );
define( 'SECURE_AUTH_KEY',  '1=rbd_|^}ZTl$}_|Ap1_ P=VvDW%P&,/BUBFpB&-2u/IboUygE*75]5trn[t^S,t' );
define( 'LOGGED_IN_KEY',    ')iOwnOS~=/ZG%o_wKjA9$[%}~tl[VUlcl([YW{h8w-%mQA^6k_fZ&?61dy%zXVhU' );
define( 'NONCE_KEY',        'J^ >PE~),#(!,@8Q%ghN919i;xtC<2z]Dj&Uj?~.ng8W+!3H[[/J$J~V<Fy<kzr+' );
define( 'AUTH_SALT',        'o,Ey8t8|vu2z%ctbE`,3{%05/5m+wY|2Q,`E.cdehG-F5y&SeT>&(_QbV)bw-V9U' );
define( 'SECURE_AUTH_SALT', 'SInvP7BXU]{r@?xvB(MMH~$(Wt<VB3+l#!bH*@u2&?@ {M1[a?G5KVC<JZX8bF.A' );
define( 'LOGGED_IN_SALT',   'kK.VRPKx+l:hqZ7Ky]S0c$ 14A$>9]cKd}blFMDj~9 LM~PM~@Ad1_]tA2LW%q^z' );
define( 'NONCE_SALT',       'z~dvk&W$U7=lFvfF3C.:}`BhMHe@0[jZ14B5n}^YBRQAre[qyyRU?tm`K!UCtL40' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
