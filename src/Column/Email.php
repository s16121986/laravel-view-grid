<?php

namespace Gsdk\Grid\Column;

use Gsdk\Grid\Support\AbstractColumn;

class Email extends AbstractColumn
{
    protected array $options = [
        'href' => 'mailto:{value}'
    ];

    protected function init()
    {
        $this->setOption('href', 'mailto:{' . $this->name . '}');
    }
}
