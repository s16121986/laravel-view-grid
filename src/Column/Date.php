<?php

namespace LaravelViewGrid\Column;

use LaravelViewGrid\Support\AbstractColumn;

class Date extends AbstractColumn
{
    protected array $options = [
        'format' => 'd.m.Y'
    ];

    public function formatValue($value, $row = null)
    {
        if (!$value instanceof \DateTimeInterface) {
            $value = new \DateTime($value);
        }

        return parent::formatValue($value->format($this->format), $row);
    }
}
