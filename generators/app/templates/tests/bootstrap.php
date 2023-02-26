<?php
/**
 * PHPUnit bootstrap file.
 */

// Create test tables if needed so that the working tables do not get deleted.
function _copy_database_tables() {
	if ( ! empty( getenv( '_PHPUNIT_SKIP_TABLE_COPYING' ) ) ) {
		return;
	}

	$table_prefix = 'wpphpunittests_'; // Table prefix used in tests.

	$host     = getenv( '_DB_HOST' );
	$user     = getenv( '_DB_USER' );
	$password = getenv( '_DB_PASSWORD' );
	$database = getenv( '_DB_NAME' );

	$db = new mysqli( $host, $user, $password, $database );

	if ( $db->connect_error ) {
		die( 'Connection failed: ' . $db->connect_error );
	}

	// Get production tables
	$tables = $db->query( 'SHOW TABLES' );
	$tables = $tables->fetch_all();
	$tables = \array_filter( $tables, fn( $table ) => ! str_starts_with( reset( $table ), $table_prefix ) );

	$original_table_prefix  = explode( '_', reset( $tables )[0] )[0];
	$original_prefix_length = strlen( $original_table_prefix ) + 1;

	foreach ( $tables as $table ) {
		$table           = reset( $table );
		$table_base_name = substr( $table, $original_prefix_length );
		$new_table       = $table_prefix . $table_base_name;
		$db->query( "DROP TABLE IF EXISTS {$new_table}" );
		$db->query( "CREATE TABLE {$new_table} SELECT * FROM {$table}" );
	}

	$db->close();
}

_copy_database_tables();

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
/**
 * Registers theme.
 */
function _register_theme() {

	$theme_dir     = dirname( __DIR__ );
	$current_theme = basename( $theme_dir );
	$theme_root    = dirname( $theme_dir );

	add_filter( 'theme_root', function () use ( $theme_root ) {
		return $theme_root;
	} );

	register_theme_directory( $theme_root );

	add_filter( 'pre_option_template', function () use ( $current_theme ) {
		return $current_theme;
	} );

	add_filter( 'pre_option_stylesheet', function () use ( $current_theme ) {
		return $current_theme;
	} );
}

tests_add_filter( 'muplugins_loaded', '_register_theme' );

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
