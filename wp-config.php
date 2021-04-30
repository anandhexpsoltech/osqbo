<?php

define('FORCE_SSL_ADMIN', true);
define('WP_HOME', 'http://localhost/osqbo');
define('WP_SITEURL', 'http://localhost/osqbo');

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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'osaioas');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '}$^ Nm6>_r/S-oO6b$ck9>wu`QR7g]>+?[LP8b$#;|4|T-TW-vs4po&adC0Ni/U3');
define('SECURE_AUTH_KEY',  'mc+s^UXIV*r_RtiUD>y}Vw mlKZl|&p4M>?(Gv4=5#9wexc8l4y+m%VS+|~|f4u9');
define('LOGGED_IN_KEY',    'M)<+eh>A{B[=lsp*)UTG2*bb+fs$fu~!^}X$$-k+J[+-}&mR7&fd+,N2PsW=$>wf');
define('NONCE_KEY',        '&wG6UgpGiwp:8jQBv?z)66-M&XjQs+DL|6IRwNGK5/:wJIIAOu,{^|Se+mmQ}e}_');
define('AUTH_SALT',        'kJQgKCn|NuhjQ(tKPxXjEa=p@xi03:;N9<@p%6uYi=(O#@;Y#423R|UZ?gWs%@E;');
define('SECURE_AUTH_SALT', '?>ufaY]VAG!-CnDXY;/RG|Hk^YLK=~pM)~JR&8GUCcDDk/1%e#i`zFvF|{b)+DS4');
define('LOGGED_IN_SALT',   '24.c0*-bPrLfUDIq%n^$Q6!TK]B$] Ma>(E_cE2v,Pq;o HY9e0+Ua1y2}*8xq4G');
define('NONCE_SALT',       '>|7K1mr+~!d4(8Q*{5jn6Bea+rSq-Mx?JMyKZ]%qOo~VV[Mnse}vsjJ -;>9yJQ(');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'kps_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
