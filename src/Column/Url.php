<?php

namespace Gsdk\Grid\Column;

use Gsdk\Grid\Support\AbstractColumn;

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
