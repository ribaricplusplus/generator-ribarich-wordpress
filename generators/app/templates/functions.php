<?php
<%- pluginText %>

define( '<%- fileConstant %>', __FILE__ );

require __DIR__ . '/vendor/autoload.php';

function <%- snakeName %>_init() {
	$wputm = new \WpUtm\Main(
		array(
			'definitions' => array(
				\WpUtm\Interfaces\IDynamicCss::class => \DI\autowire( \<%- capitalizedName %>\DynamicCss::class ),
				\WpUtm\Interfaces\IDynamicJs::class  => \DI\autowire( \<%- capitalizedName %>\DynamicJs::class ),
				'main_file'                          => <%- fileConstant %>,
				'type'                               => '<%- wpUtilitatemProjectType %>',
				'prefix'                             => '<%- kebabName %>',
			),
		)
	);

	$wputm->get( \<%- capitalizedName %>\Main::class )->init();
}

<%- snakeName %>_init();
