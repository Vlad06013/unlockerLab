<?php

namespace App\Orchid\Layouts\DoorsLocks;

use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DoorsLockModelsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'doorsLockModel';

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
                ->render(function ($doorsLockModel) {
                    return ModalToggle::make($doorsLockModel->name)
                        ->modal('editDoorsLockModel')
                        ->modalTitle('Редактирование '.$doorsLockModel->name)
                        ->method('editDoorsLockModel')
                        ->asyncParameters([
                            'doorsLockMark' => $doorsLockModel->car_mark_id,
                            'doorsLockModel' => $doorsLockModel->id,
                        ]);
                }),
        ];
    }
}
