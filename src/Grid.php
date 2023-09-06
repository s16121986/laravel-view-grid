<?php

namespace Sdk\Grid;

/**
 * @method static data(mixed $data)
 * @method static orderBy(string $name, string $order = 'asc')
 * @method static paginator(int|Paginator $paginator = null)
 * @method static boolean(string $name, array $options = [])
 * @method static date(string $name, array $options = [])
 * @method static datePeriod(string $name, array $options = [])
 * @method static email(string $name, array $options = [])
 * @method static number(string $name, array $options = [])
 * @method static phone(string $name, array $options = [])
 * @method static text(string $name, array $options = [])
 * @method static url(string $name, array $options = [])
 * @method static emptyText(string $text)
 * @method static class(string $cssClass)
 * @method static header(bool $showHeader)
 */
class Grid
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
