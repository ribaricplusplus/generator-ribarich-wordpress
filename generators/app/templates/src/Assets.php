<?php
namespace <%- capitalizedName %>;

use WpUtm\AssetsRegistration;

class Assets {
	public function init() {
		$this->ar->register_assets();

		\add_action( 'enqueue_block_assets', array( $this, 'enqueue_scripts_and_styles' ) );
		\add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_scripts_and_styles' ) );
	}

	public function __construct(
		public AssetsRegistration $ar,
	) {}

	public function enqueue_scripts_and_styles() {
		\wp_enqueue_style( '<%- kebabName %>-common' );
	}
}
