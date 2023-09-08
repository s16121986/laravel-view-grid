<?php

namespace Gsdk\Grid\Feature;

use Gsdk\Grid\GridBuilder;

abstract class AbstractFeature {

	protected $grid = null;

	public function __construct(GridBuilder $grid) {
		$this->grid = $grid;
	}

}
