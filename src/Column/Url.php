<?php

namespace LaravelViewGrid\Column;

use LaravelViewGrid\Support\AbstractColumn;

class Url extends AbstractColumn
{
    protected $_options = [
        //'href' => '%value%',
        'target' => ''
    ];

    protected function init()
    {
        $this->setOption('href', '%' . $this->name . '%');
    }
}
