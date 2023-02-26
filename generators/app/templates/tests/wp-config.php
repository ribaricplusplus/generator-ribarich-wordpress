<?php

/* Path to the WordPress codebase you'd like to test. Add a forward slash in the end. */
define( 'ABSPATH', dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) . '/' );

// Test with multisite enabled.
// Alternatively, use the tests/phpunit/multisite.xml configuration file.
// define( 'WP_TESTS_MULTISITE', true );

// Force known bugs to be run.
// Tests with an associated Trac ticket that is still open are normally skipped.
// define( 'WP_TESTS_FORCE_KNOWN_BUGS', true );

// Test with WordPress debug mode (default).
define( 'WP_DEBUG', true );

// ** MySQL settings ** //

// This configuration file will be used by the copy of WordPress being tested.
// wordpress/wp-config.php will be ignored.

define( 'DB_NAME', getenv( '_DB_NAME' ) );
define( 'DB_USER', getenv( '_DB_USER' ) );
define( 'DB_PASSWORD', getenv( '_DB_PASSWORD' ) );
define( 'DB_HOST', getenv( '_DB_HOST' ) );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

$table_prefix = 'wpphpunittests_'; // Table prefix used in tests.

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 */
define( 'AUTH_KEY', 'a5;VgX?**M/bTl9~2zx#(pmLJN6mlOiazr(=iQ)Q,)I-xxcE??Z2-~zr2ErQjlP,' );
define( 'SECURE_AUTH_KEY', 'mub6|sX%bCJB/B=7+R>#T0w0tc++E-my_6(cz6 )3kE3C{Hbi;8,IAI|Uc4g ^U,' );
define( 'LOGGED_IN_KEY', 'h+*]#]+qbv^6p_j!HQtd-z[~y^=-WE>TwHy-vgdQP*tX~0{%Wt+]eO-18dE_>I?E' );
define( 'NONCE_KEY', 'n/25EopWq+),aE%?J I8TYW1k4%61G;hjQL7CN4`]1I+_ )HXo~b+7`*f)[FRj$@' );
define( 'AUTH_SALT', '`]UDFv})g;Tp8(rELJpvpa_2bjTngWNM<$B%xA5U>#V-e}!?0>>y#8axe+6in|ZX' );
define( 'SECURE_AUTH_SALT', '+Q!l$LQ>5bPxV$+bWp!e67E .o`>A0]4L<;E1%}S/LZYX>Mf/7:vRMe]ia,D(c5*' );
define( 'LOGGED_IN_SALT', '+Xf-9Xsm$a)u|_N`7Fb4_vY&8>+xi[snu6&H]]RqSD)a?(H!q.kQeEYq|yX&[Y|%' );
define( 'NONCE_SALT', 'p_f3?v~K`qg%QzPQ<pfe=n8(oR_&hWGP7?WgsiHd/>/R_KjOI=Kw8K<*,pu>I}du' );

define( 'WP_TESTS_DOMAIN', '<%- localDomain %>' );
define( 'WP_TESTS_EMAIL', 'admin@wptest.local' );
define( 'WP_TESTS_TITLE', '<%- projectName %>' );

define( 'WP_PHP_BINARY', 'php' );

define( 'WPLANG', '' );
