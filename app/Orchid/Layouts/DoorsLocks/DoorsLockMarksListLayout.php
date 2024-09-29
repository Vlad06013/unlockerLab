<?php

namespace App\Orchid\Layouts\DoorsLocks;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DoorsLockMarksListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'doorsLockMark';

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
                ->render(function ($doorsLockMark) {
                    return Link::make($doorsLockMark->name)
                        ->route('platform.doorsLockModel.list', ["doorsLockMark"=>$doorsLockMark->id]);
                }),
        ];
    }
}
