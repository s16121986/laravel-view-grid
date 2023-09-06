<?php

namespace Sdk\Grid\Data;

use Sdk\Grid\Support\Sorting;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Sdk\Grid\Paginator;

class EloquentQuery implements DataInterface
{
    private $data;

    public static function isEloquentQuery($data): bool
    {
        return $data instanceof Builder
            || $data instanceof QueryBuilder
            || $data instanceof Relation;
    }

    public function __construct(private $query) {}

    public function getQuery()
    {
        return $this->query;
    }

    public function paginator(Paginator $paginator): static
    {
        $paginator->query($this->query);
        return $this;
    }

    public function sorting(Sorting $sorting): static
    {
        $sorting->query($this->query);
        return $this;
    }

    public function get(): iterable
    {
        return $this->data ?? ($this->data = $this->query->get());
    }

    public function isEmpty(): bool
    {
        return $this->get()->isEmpty();
    }

    public function cursor()
    {
        return $this->query->cursor();
    }
}
