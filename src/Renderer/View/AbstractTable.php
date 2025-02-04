<?php

namespace LaravelViewGrid\Renderer\View;

use LaravelViewGrid\GridBuilder;

abstract class AbstractTable
{
    public function render(GridBuilder $grid): string
    {
        if ($grid->getData()->isEmpty()) {
            return '<div class="grid-empty-text">' . $grid->getOption('emptyText') . '</div>';
        }

        $html = $this->renderTable($grid);

        if (($paginator = $grid->getPaginator())) {
            $html .= $paginator->render();
        }

        return $html;
    }

    public function initFeatures(): array
    {
        if (!$this->grid->features) {
            return [];
        }

        $features = [];
        $featuresTemp = $this->grid->features;
        if (!is_array($featuresTemp)) {
            $featuresTemp = [$featuresTemp];
        }

        foreach ($featuresTemp as $name) {
            if (!preg_match('/^[a-z_]+$/i', $name)) {
                throw new \Exception('Invalid feature');
            }

            $cls = 'LaravelViewGrid\Feature\\' . ucfirst($name);
            if (!class_exists($cls, true)) {
                throw new \Exception('Feature not exists');
            }

            $features[$name] = new $cls($this->grid);
        }

        return $features;
    }

    abstract protected function renderTable(GridBuilder $grid): string;
}
