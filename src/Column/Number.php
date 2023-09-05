<?php

namespace Gsdk\Grid\Column;

use Gsdk\Grid\Support\AbstractColumn;

class Number extends AbstractColumn
{
    protected array $options = [
        'format' => 'NFD=2;NDS=,;NGS= '
    ];

    public function prepareValue($value)
    {
        if (self::isNullValue($value)) {
            return null;
        }

        return (float)$value;
    }

    public function formatValue($value, $row = null)
    {
        return ($this->format ? app('format')->number($value, $this->format) : $value);
    }

    private static function isNullValue($value): bool
    {
        return ('' === $value || null === $value);
    }
}
