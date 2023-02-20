const path = require( 'path' );
const baseConfig = require( '@wordpress/scripts/config/webpack.config.js' );

const common = {
	resolve: {
		...baseConfig.resolve,
		alias: {
			...baseConfig.resolve.alias,
			Root: __dirname,
		},
	},
};

module.exports = {
	...baseConfig,
	...common,
	output: {
		...baseConfig.output,
		path: path.join( __dirname, 'build/js' ),
		filename: '[name].bundle.js',
	},
	entry: {
		// Add entry points here. Every entry point will result in a separate script
		// which can be enqueued as wp_enqueue_script( 'brunos-$entry_point_name' ).
		// The script will be automatically minified. See for example the sample script
		// defined below.
		'sample-script': './js/sample-script/sample-script.ts',
	},
};
