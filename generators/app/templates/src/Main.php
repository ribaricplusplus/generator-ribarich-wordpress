<?php

namespace <%- capitalizedName %>;

class Main {
	public function init() {
		$this->assets->init();
	}

	public function __construct(
		public Assets $assets,
	) {}
}
