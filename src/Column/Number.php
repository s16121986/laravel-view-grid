<?php

namespace Gsdk\Grid\Column;

use Gsdk\Grid\Support\AbstractColumn;

class Number extends AbstractColumn
{
    protected array $options = [
        'decimals' => 0,
        'decimalSeparator' => ',',
        'thousandsSeparator' => ' ',
        'zerofill' => false,
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
        return $this->format
            ? ($this->format)($value, $row)
            : number_format($value, $this->decimals, $this->decimalSeparator, $this->thousandsSeparator);
    }

    private static function isNullValue($value): bool
    {
        return ('' === $value || null === $value);
    }
}
