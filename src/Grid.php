<?php

namespace Sdk\Grid;

use Illuminate\Support\Facades\Facade;

/**
 * @method static GridBuilder data(mixed $data)
 * @method static GridBuilder orderBy(string $name, string $order = 'asc')
 * @method static GridBuilder paginator(int|Paginator $paginator = null)
 * @method static GridBuilder boolean(string $name, array $options = [])
 * @method static GridBuilder date(string $name, array $options = [])
 * @method static GridBuilder datePeriod(string $name, array $options = [])
 * @method static GridBuilder email(string $name, array $options = [])
 * @method static GridBuilder number(string $name, array $options = [])
 * @method static GridBuilder phone(string $name, array $options = [])
 * @method static GridBuilder text(string $name, array $options = [])
 * @method static GridBuilder url(string $name, array $options = [])
 * @method static GridBuilder emptyText(string $text)
 * @method static GridBuilder class(string $cssClass)
 * @method static GridBuilder header(bool $showHeader)
 */
class Grid extends Facade
{
    protected static $cached = false;

    protected static function getFacadeAccessor()
    {
        return GridBuilder::class;
    }
}
