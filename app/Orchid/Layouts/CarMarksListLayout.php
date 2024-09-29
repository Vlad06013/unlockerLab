<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CarMarksListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'carMarks';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name','Марка')
                ->align('center')
                ->width('100px')
                ->render(function ($carMark) {
                    return Link::make($carMark->name)
                        ->route('platform.carmodel.list', ["carMark"=>$carMark->id]);
                }),
        ];
    }
}
