<?php

namespace LaravelViewGrid\Feature;

use LaravelViewGrid\GridBuilder;

abstract class AbstractFeature {

	protected $grid = null;

	public function __construct(GridBuilder $grid) {
		$this->grid = $grid;
	}

}
