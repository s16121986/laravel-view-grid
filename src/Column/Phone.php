<?php

namespace LaravelViewGrid\Column;

use LaravelViewGrid\Support\AbstractColumn;

class Phone extends AbstractColumn
{
    protected $_options = [
        'href' => 'tel:%value%'
    ];
}
