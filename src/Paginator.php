<?php

namespace Gsdk\Grid;

use Illuminate\Support\Facades\Request;

/**
 * @property int $step
 */
class Paginator
{
    protected static array $defaultOptions = [
        'step' => 10,
        'pagesStep' => 4,
        'prevText' => '{{lang:Prev}}',
        'nextText' => '{{lang:Next}}',
        'baseUrl' => null,
        'queryParam' => 'p',
        'view' => 'layouts.paginator'
    ];

    protected $current;

    protected int $count = 0;

    protected mixed $query;

    protected array $options = [];

    public static function setDefaults(array $options): void
    {
        self::$defaultOptions = array_merge(self::$defaultOptions, $options);
    }

    public function __get($name)
    {
        return match ($name) {
            'offset' => $this->getStartIndex(),
            default => ($this->options[$name] ?? null),
        };
    }

    public function __set($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function __construct(int|array $options = null)
    {
        if (is_int($options)) {
            $options = ['step' => $options];
        } elseif (!$options) {
            $options = [];
        }

        $this->setOptions(array_merge(self::$defaultOptions, $this->options, $options));
    }

    public function setOptions($options): static
    {
        foreach ($options as $k => $v) {
            $this->options[$k] = $v;
        }

        return $this;
    }

    public function getQuery($name, $default = null)
    {
        return ($_GET[$name] ?? $default);
    }

    public function setStep($step): static
    {
        $this->options['step'] = $step;

        return $this;
    }

    public function setCount($count): static
    {
        $this->count = $count;

        return $this;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getOffset(): int
    {
        return ($this->getCurrentPage() - 1) * $this->step;
    }

    public function getStep(): int
    {
        return $this->step;
    }

    public function getStartIndex(): int
    {
        return $this->getOffset();
    }

    public function getCurrentPage(): int
    {
        if (null !== $this->current) {
            return $this->current;
        }

        $current = (int)$this->getQuery($this->queryParam);
        if ($current < 1) {
            $current = 1;
        }

        return $this->current = $current;
    }

    public function getPageCount(): int
    {
        return ceil($this->count / $this->step);
    }

    public function link($page, $text = null, $class = ''): string
    {
        if (null === $text) {
            $text = $page;
        }

        $url = $this->baseUrl;
        if (null === $url) {
            $url = $this->baseUrl = '/' . Request::path();
        }

        $params = Request::query();
        if ($page == 1) {
            unset($params[$this->queryParam]);
        } else {
            $params[$this->queryParam] = $page;
        }

        if ($params) {
            $url .= '?' . http_build_query($params);
        }

        return '<a class="' . $class . '" href="' . $url . '">' . $text . '</a>';
    }

    private function getPages(): ?\stdClass
    {
        $pageCount = $this->getPageCount();
        if ($pageCount <= 1) {
            return null;
        }

        $pages = new \stdClass();
        $pages->count = $this->count;
        $pages->step = $this->step;
        $pages->first = 1;
        $pages->current = $this->getCurrentPage();
        $pages->last = $pageCount;
        $pages->previous = null;
        $pages->next = null;

        if ($pages->current - 1 > 0) {
            $pages->previous = $pages->current - 1;
        }

        if ($pages->current + 1 <= $pageCount) {
            $pages->next = $pages->current + 1;
        }

        $firstPageInRange = $pages->current - $this->pagesStep;
        $lastPageInRange = $pages->current + $this->pagesStep;
        if ($firstPageInRange <= 2) {
            $firstPageInRange = 1;
        }

        if ($lastPageInRange > $pages->last - 2) {
            $lastPageInRange = $pages->last;
        }

        $pagesInRange = [];
        for ($i = $firstPageInRange; $i <= $lastPageInRange; $i++) {
            $pagesInRange[] = $i;
        }

        $pages->pagesInRange = $pagesInRange;
        $pages->firstPageInRange = $firstPageInRange;
        $pages->lastPageInRange = $lastPageInRange;

        return $pages;
    }

    public function query($query): static
    {
        $count = $query->count();
        $this->setCount($count);
        $query->limit($this->step)->offset($this->getStartIndex());

        return $this;
    }

    public function render($view = null)
    {
        $pages = $this->getPages();
        if (!$pages) {
            return '';
        }

        return view($view ?? $this->view, [
            'pages' => $pages,
            'paginator' => $this
        ]);
    }

    public function __toString(): string
    {
        return (string)$this->render();
    }
}
