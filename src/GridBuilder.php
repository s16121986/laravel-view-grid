<?php

namespace Gsdk\Grid;

/**
 * @method $this boolean(string $name, array $options = [])
 * @method $this date(string $name, array $options = [])
 * @method $this datePeriod(string $name, array $options = [])
 * @method $this email(string $name, array $options = [])
 * @method $this number(string $name, array $options = [])
 * @method $this phone(string $name, array $options = [])
 * @method $this text(string $name, array $options = [])
 * @method $this url(string $name, array $options = [])
 * @method $this emptyText(string $text)
 * @method $this class(string $cssClass)
 * @method $this header(bool $showHeader)
 */
class GridBuilder
{
    use Concerns\HasColumns;
    use Concerns\HasExtensions;

    protected Support\Options $options;

    protected Support\Sorting $sorting;

    protected Renderer\Renderer $renderer;

    protected Data\DataInterface $data;

    protected ?Paginator $paginator = null;

    protected static array $defaultOptions = [];

    public static function setDefaults(array $options): void
    {
        static::$defaultOptions = $options;
    }

    public function __construct($options = [])
    {
        $this->options = new Support\Options(array_merge(static::$defaultOptions, $options));
        $this->sorting = new Support\Sorting($options);
        $this->renderer = new Renderer\Renderer($options);
        $this->data = new Data\EmptyData();

        $this->build();
    }

    public function __call(string $name, array $arguments)
    {
        if (!isset($arguments[0])) {
            throw new \ArgumentCountError('Argument required');
        }

        if ($this->options->hasOption($name)) {
            $this->options->setOption($name, $arguments[0] ?? null);
        } else {
            $id = $arguments[0];
            unset($arguments[0]);
            $this->addColumn($id, $name, $arguments[1] ?? []);
        }

        return $this;
    }

    public function getOption(string $name)
    {
        return $this->options->$name;
    }

    public function setOption(string $name, mixed $value): static
    {
        $this->options->setOption($name, $value);

        return $this;
    }

    public function getSorting(): Support\Sorting
    {
        return $this->sorting;
    }

    public function paginator(int|Paginator $paginator = null): static
    {
        if (null === $paginator) {
            $this->paginator = new Paginator();
        } elseif (is_numeric($paginator)) {
            $this->paginator = new Paginator($paginator);
        } else {
            $this->paginator = $paginator;
        }

        return $this;
    }

    public function getPaginator(): ?Paginator
    {
        return $this->paginator;
    }

    public function getData(): Data\DataInterface
    {
        return $this->data;
    }

    public function data($data): static
    {
        $this->data = Data\DataFactory::factory($data);

        return $this;
    }

    public function orderBy(string $name, string $order = 'asc'): static
    {
        $this->sorting->orderBy($name, $order);

        return $this;
    }

    public function render(): string
    {
        $this->prepareData();

        return $this->renderer->render($this);
    }

    public function __toString(): string
    {
        return $this->render();
    }

    protected function prepareData(): void
    {
        if ($this->paginator) {
            $this->data->paginator($this->paginator);
        }

        $this->sorting->fromRequest();

        $this->data->sorting($this->sorting);
    }

    protected function build(): void
    {
    }
}
