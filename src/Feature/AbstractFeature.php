<?php

namespace Sdk\Grid\Feature;

use Sdk\Grid\Grid;

abstract class AbstractFeature {

	protected $grid = null;

	public function __construct(Grid $grid) {
		$this->grid = $grid;
	}

}
