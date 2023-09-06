<?php

namespace Sdk\Grid;

use Illuminate\Support\Facades\Facade;

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
class GridFacade extends Facade
{
    protected static $cached = false;

    protected static function getFacadeAccessor()
    {
        return Grid::class;
    }
}
