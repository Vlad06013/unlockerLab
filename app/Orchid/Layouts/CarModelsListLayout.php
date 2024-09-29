<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CarModelsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'carModels';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name','Модель')
                ->align('center')
                ->width('100px')
                ->render(function ($carModels) {
                    return Link::make($carModels->name)
                        ->route('platform.carmodel.detail', ["carModel" => $carModels->id]);
                }),
        ];
    }
}
