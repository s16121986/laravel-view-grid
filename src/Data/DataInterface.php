<?php

namespace Sdk\Grid\Data;

use Sdk\Grid\Support\Sorting;
use Sdk\Grid\Paginator;

interface DataInterface
{
	public function paginator(Paginator $paginator): static;

	public function sorting(Sorting $sorting): static;

	public function isEmpty(): bool;

	public function get(): iterable;
}