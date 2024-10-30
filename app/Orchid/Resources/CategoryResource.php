<?php

namespace App\Orchid\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\TD;
use Valibool\TelegramConstruct\Models\Message;
use Valibool\TelegramConstruct\Models\Relation\TgMessagable;

class CategoryResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Category::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
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

    public function onSave(Request $request, Category $model) {
        $data = $request->all();
        $model->forceFill($data)->save();

        $model->makeItemAsButton(
            "Категории", null, "name", "id"
        );
    }

}
