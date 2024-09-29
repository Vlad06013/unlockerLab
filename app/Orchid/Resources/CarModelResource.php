<?php

namespace App\Orchid\Resources;

use App\Models\CarMark;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\TD;

class CarModelResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\CarModel::class;

    public static function displayInNavigation(): bool
    {
        return false;
    }
    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Select::make("car_mark_id")->title("Подраздел")->fromModel(CarMark::class, "name"),
            Input::make("name")->title("Название")->type("text"),
        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('car_mark_id', 'Марка')
                ->render(function ($model) {
                    if($model->carMark) {
                        return $model->carMark->name;
                    }
                }),
            TD::make('name', 'Название'),
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }
}
