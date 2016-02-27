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
define('DB_NAME', 'wordpress_1');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'Kchv-EALW: ;~/k]F9+Z,3`dKEZv;iaR>/--jiss),-.bCm8P<y-XyYHfk/A_=y1');
define('SECURE_AUTH_KEY',  '4J;@jv4IgYR<yt(Ss_.eG&7j;A`g:g+d_6H9M=N;P Q>]ZcX$b$T:rp2VI_PFE9Q');
define('LOGGED_IN_KEY',    'm+r(v%2=Q}m]v@[:~@xmOa~99*^y4:n|<Iq)tHcF?r6|3L^^2-ZkKO_^qmBJ;yo`');
define('NONCE_KEY',        '=>HX-{aT4e=~;i/7~JdMmS!W*l,`10+&qNFgv6!,{*grRDE-=a1 D}ta5Ep[Px7_');
define('AUTH_SALT',        ',|.{bix;qk)$NyXv$?[:KPfU%0w2[b.rW.ED$^O74pV GcOQ-|!=IB 7}V?+l-5?');
define('SECURE_AUTH_SALT', ']8CUNVb*bh;hQdx#`Z+8t|rtCdXzB7G-s,PmoA{js9LjL@U~-c2}wLuQ4d.1&c]S');
define('LOGGED_IN_SALT',   'Mi4P>u)4J>LY%?d@x8})r~{<rITUWc9ew|-rutK@Vp@6[8Ccg:1{3</tx+~hS[M`');
define('NONCE_SALT',       'J+=g`gTWl1d(D*UiT-x%;}2wS.0*)_|+QpabVR%h{Pn`B_yF)GC7yRLUc1h||mV;');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', FALSE);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
