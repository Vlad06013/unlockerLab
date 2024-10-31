<?php

namespace App\Orchid\Resources;

use App\Models\DoorsLockMark;
use App\Models\DoorsLockModel;
use App\Models\LockMechSecretType;
use App\Models\LockType;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\TD;

class DoorsLockModelResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\DoorsLockModel::class;

    public static function label(): string
    {
        return "Модели дверных замков";
    }

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
            Group::make([

                Relation::make('doors_lock_mark_id')
                    ->fromModel(DoorsLockMark::class, 'name')
                    ->title('Производитель'),
                Input::make("name")->title("Название")->type("text"),
            ]),

           SimpleMDE::make("description")->title("Описание"),
            Group::make([

                Relation::make('lock_type_id')
                    ->fromModel(LockType::class, 'name')
                    ->title('Тип замка'),
                Relation::make('lock_mech_secret_type_id')
                    ->fromModel(LockMechSecretType::class, 'name')
                    ->title('Тип механизма секретности'),
                Select::make('secret_type')->options([
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ])->title("Тип секретности"),
                Select::make('resistance_class')->options([
                    'A' => 'A',
                    'B' => 'B',
                ])->title("Класс Взломостойкости"),
            ]),

            Group::make([
                CheckBox::make("tail_latch")->title("Фалевая защелка")->sendTrueOrFalse(),
                CheckBox::make("latch_inside")->title("Защелка изнутри")->sendTrueOrFalse(),
                CheckBox::make("rods")->title("Наличие тяг")->sendTrueOrFalse(),
            ]),
            Group::make([
                Input::make("center_distance")->title("Межосевое расстояние - мм")->type("number"),
                Input::make("backset")->title("Бэксет (удаление ключевого отверстия) - мм")->type("number"),
                Input::make("end_strip_length")->title("Длина торцевой планки - мм")->type("number"),
                Input::make("end_strip_width")->title("Ширина торцевой планки - мм")->type("number"),
                Input::make("center_distance_fastenings")->title("Межосевое расстояние креплений замка - мм")->type("number"),
                Input::make("crossbar_diameter")->title("Диаметр ригеля(Высота если квадратный) - мм")->type("number"),
                Input::make("deadbolt_overhang")->title("Вылет ригеля - мм")->type("number"),
                Input::make("overhang_count")->title("Кол-во ригелей")->type("number"),
                Input::make("body_height")->title("Высота корпуса замка - мм")->type("number"),
                Input::make("case_depth")->title("Глубина корпуса замка - мм")->type("number"),
                Input::make("width_depth")->title("Ширина корпуса замка - мм")->type("number"),
            ]),
            Select::make('key_type')->options([
                'Сувальдный' => 'Сувальдный',
                'Крестовый' => 'Крестовый',
                'Английский' => 'Английский',
                'Финский' => 'Финский',
                'Реечный' => 'Реечный',
                'Помповый' => 'Помповый',
            ])->title("Тип ключа"),

            Select::make('locking_from_inside')->options([
                'Ключом' => 'Ключом',
                'Ручкой' => 'Ручкой',
                'Нету' => 'Нету',
            ])->title("Запирание изнутри")->empty(),
            Upload::make('attachment')->title('Изображения')
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
            TD::make('doors_lock_mark_id', 'Производитель')->render(function ($model) {
                return $model->mark->name;
            }),
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

    public function onSave(ResourceRequest $request, DoorsLockModel $model)
    {
        $data = $request->all();
        if (!isset($data['attachment'])) {
            $attachment = [];
        } else {
            $attachment = $data['attachment'];
        }
        unset($data['attachment']);
        $model->forceFill($data)->save();
        $model->attachment()->sync($attachment);
    }
}
