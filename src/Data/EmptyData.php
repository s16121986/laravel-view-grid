<?php

namespace LaravelViewGrid\Data;

use LaravelViewGrid\Support\Sorting;
use LaravelViewGrid\Paginator;

class EmptyData implements DataInterface
{
	public function paginator(Paginator $paginator): static
	{
		return $this;
	}

	public function sorting(Sorting $sorting): static
	{
		return $this;
	}

	public function isEmpty(): bool
	{
		return true;
	}

	public function get(): iterable
	{
		return [];
	}
}
