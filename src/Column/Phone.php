<?php

namespace Gsdk\Grid\Column;

use Gsdk\Grid\Support\AbstractColumn;

class Phone extends AbstractColumn
{
    protected $_options = [
        'href' => 'tel:%value%'
    ];
}
