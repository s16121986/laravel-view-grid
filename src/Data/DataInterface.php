<?php

namespace LaravelViewGrid\Data;

use LaravelViewGrid\Support\Sorting;
use LaravelViewGrid\Paginator;

interface DataInterface
{
	public function paginator(Paginator $paginator): static;

	public function sorting(Sorting $sorting): static;

	public function isEmpty(): bool;

	public function get(): iterable;
}
