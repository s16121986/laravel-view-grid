<?php

namespace Sdk\Grid\Feature;

use Sdk\Grid\GridBuilder;

abstract class AbstractFeature {

	protected $grid = null;

	public function __construct(GridBuilder $grid) {
		$this->grid = $grid;
	}

}
