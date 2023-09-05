<?php

namespace Gsdk\Grid\Column;

use Gsdk\Grid\Support\AbstractColumn;

class Date extends AbstractColumn
{
    protected array $options = [
        'format' => 'd.m.Y'
    ];

    public function formatValue($value, $row = null)
    {
        return parent::formatValue(app('format')->date($value, $this->format), $row);
    }
}
