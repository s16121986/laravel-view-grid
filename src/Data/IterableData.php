<?php

namespace LaravelViewGrid\Data;

use LaravelViewGrid\Support\Sorting;
use LaravelViewGrid\Paginator;

class IterableData implements DataInterface
{
    public function __construct(private readonly iterable $data) {}

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
        if ($this->data instanceof \Countable) {
            return count($this->data) === 0;
        }

        return empty($this->data);
    }

    public function get(): iterable
    {
        return $this->data;
    }
}
