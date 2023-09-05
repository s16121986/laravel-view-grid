<?php

namespace Gsdk\Grid\Support;

class Options
{
    protected array $options = [
        'emptyText' => '',
        'class' => 'table table-striped',
        'header' => true,
        'view' => 'Table',
        'viewConfig' => null,
        'orderUrl' => null
    ];

    public function __construct(array $options = [])
    {
        $this->setOptions($options);
    }

    public function setOptions(array $options): static
    {
        foreach ($options as $k => $v) {
            $this->setOption($k, $v);
        }
        return $this;
    }

    public function setOption($key, $option): static
    {
        $this->options[$key] = $option;
        return $this;
    }

    public function hasOption($key): bool
    {
        return array_key_exists($key, $this->options);
    }

    public function __get(string $name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }

        return $this->options[$name] ?? null;
    }

    public function __set($name, $value)
    {
        if ($name === 'emptyGridText') {
            $name = 'emptyText';
        }

        $this->options[$name] = $value;
    }
}
