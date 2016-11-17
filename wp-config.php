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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', '');

/** MySQL database username */
define('DB_USER', '');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', '');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '/CHO;h0CXhhb2Y^gMmH bSN{HuD~`n5U|:UAMi%h~||t~^L*`;qE{CU:7u@(ok,I');
define('SECURE_AUTH_KEY',  'yKZh!h)-0FFViYzZOOHD9Sge^5^=RXsT>uSVqd2TH2li%@Tvj#8l8|uqXB0gJc3[');
define('LOGGED_IN_KEY',    '(#R]|hx)Hhi& L7stYXP%@9Z_rVfwk2rIf&hp>,uQ{=JE0g6iPxHW|l3^8;bDWIu');
define('NONCE_KEY',        '[p68AgU,@2SNMg2AZW=jU!n~r,cs8(c*#=%}h3b|63*1 +lYrO%I5Y6uC4$QWhZv');
define('AUTH_SALT',        '<d?H%#G(C;$xlAm-YuNe<HA(;|]S6;NzfQ57u9-$hyS2ME.+&bi=wRx> ,COm,Z3');
define('SECURE_AUTH_SALT', 'D{iKv ^;%4J9 ,?;T9s`8GWk`^([q3c.NxH[ z4@M?B2!nfgV&V(hxxraUoQj;+,');
define('LOGGED_IN_SALT',   '-[S*m]bf]p^tRh$IK}o)Kwq2Goc;rDq#dx2kbp$629RaOS]{y6Yj_PFN1FohOTr/');
define('NONCE_SALT',       'j?U@}BFoA-d9Yd^LyUs S.{J|w2bcliKHYW!=6UOXGdox[bVvc?JI<5Vo%{TgkB]');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'cb_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
