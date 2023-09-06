<?php

namespace Sdk\Grid\Column;

use Sdk\Grid\Support\AbstractColumn;

class Phone extends AbstractColumn
{
    protected $_options = [
        'href' => 'tel:%value%'
    ];
}
