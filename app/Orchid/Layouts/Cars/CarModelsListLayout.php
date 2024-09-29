<?php

namespace App\Orchid\Layouts\Cars;

use Orchid\Screen\Actions\ModalToggle;
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
                ->render(function ($carModel) {
                    return ModalToggle::make($carModel->name)
                        ->modal('editCarModel')
                        ->modalTitle('Редактирование '.$carModel->name)
                        ->method('editCarModel')
                        ->asyncParameters([
                            'carMark' => $carModel->car_mark_id,
                            'carModel' => $carModel->id,
                        ]);
                }),
        ];
    }
}
