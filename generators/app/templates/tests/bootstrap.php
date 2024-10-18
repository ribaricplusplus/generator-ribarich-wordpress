<?php
/**
 * PHPUnit bootstrap file.
 */

$_tests_dir = dirname( __DIR__ ) . '/vendor/wp-phpunit/wp-phpunit';

if ( ! $_tests_dir ) {
	echo 'Could not find test dir.';
	exit( 1 );
}

$_polyfills_path = dirname( __DIR__ ) . '/vendor/yoast/phpunit-polyfills';

define( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH', $_polyfills_path );

if ( ! file_exists( "{$_tests_dir}/includes/functions.php" ) ) {
	echo "Could not find {$_tests_dir}/includes/functions.php" . PHP_EOL; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once "{$_tests_dir}/includes/functions.php";

<% if (isTheme) { %>

$theme_folder_path = dirname( dirname( __FILE__ ) );

define( 'WP_DEFAULT_THEME', basename( $theme_folder_path );

<% } else { %>

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/<%- kebabName %>.php';
}

tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

<% } %>

// Start up the WP testing environment.
require "{$_tests_dir}/includes/bootstrap.php";
