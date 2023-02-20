<?php
<%- pluginText %>

define( '<%- fileConstant %>', __FILE__ );

require 'vendor/autoload.php';

function <%- snakeName %>_init() {
	$wputm = new \WpUtm\Main(
		array(
			'definitions' => array(
				\WpUtm\Interfaces\IDynamicCss::class => \DI\create( \<%- capitalizedName %>\DynamicCss::class ),
				\WpUtm\Interfaces\IDynamicJs::class  => \DI\create( \<%- capitalizedName %>\DynamicJs::class ),
				'main_file'                          => <%- fileConstant %>,
				'type'                               => '<%- projectType %>',
				'prefix'                             => '<%- kebabName %>',
			),
		)
	);

	$wputm->get( \<%- capitalizedName %>\Main::class )->init();
}

<%- snakeName %>_init();
