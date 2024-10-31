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
use Orchid\Screen\Sight;
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
    public static function createBreadcrumbsMessage(): string
    {
        return "Создание";
    }
    public static function createButtonLabel(): string
    {
        return "Создать";
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
                Select::make('secret_type')->options(self::$model::$secretTypes)->title("Тип секретности")->empty(),
                Select::make('resistance_class')->options(self::$model::$resistanceClass)->title("Класс Взломостойкости"),
            ]),

            Group::make([
                CheckBox::make("tail_latch")->title("Фалевая защелка")->sendTrueOrFalse(),
                CheckBox::make("latch_inside")->title("Защелка изнутри")->sendTrueOrFalse(),
                CheckBox::make("rods")->title("Наличие тяг")->sendTrueOrFalse(),
            ]),
            Group::make([
                Input::make("center_distance")->title("Межосевое расстояние - мм"),
                Input::make("backset")->title("Бэксет (удаление ключевого отверстия) - мм"),
                Input::make("end_strip_length")->title("Длина торцевой планки - мм"),
                Input::make("end_strip_width")->title("Ширина торцевой планки - мм"),
            ]),
            Group::make([

                Input::make("center_distance_fastenings")->title("Межосевое расстояние креплений замка - мм"),
                Input::make("crossbar_diameter")->title("Диаметр ригеля(Высота если квадратный) - мм"),
                Input::make("deadbolt_overhang")->title("Вылет ригеля - мм"),
                Input::make("overhang_count")->title("Кол-во ригелей")->type("number")->value(1),
            ]),
            Group::make([

                Input::make("body_height")->title("Высота корпуса замка - мм"),
                Input::make("case_depth")->title("Глубина корпуса замка - мм"),
                Input::make("width_depth")->title("Ширина корпуса замка - мм"),
            ]),
            Select::make('key_type')->options(self::$model::$keyTypes)->title("Тип ключа")->empty(),

            Select::make('locking_from_inside')->options(self::$model::$lockingFromInside)->title("Запирание изнутри")->empty(),
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
        return [
            Sight::make("doors_lock_mark_id",'Производитель')->render(fn (DoorsLockModel $model) => $model->mark->name),
            Sight::make("name",'Название'),
            Sight::make("description","Описание"),
            Sight::make("lock_type_id",'Тип замка')->render(fn (DoorsLockModel $model) => $model->lockType?$model->lockType->name:'-'),
            Sight::make("lock_mech_secret_type_id",'Тип механизма секретности')->render(fn (DoorsLockModel $model) => $model->lockMechSecretType?$model->lockType->name:'-'),
            Sight::make("secret_type",'Тип секретности'),
            Sight::make("resistance_class",'Класс Взломостойкости'),
            Sight::make("tail_latch",'Фалевая защелка')->render(fn (DoorsLockModel $model) => $model->tail_latch?"Да":"Нет"),
            Sight::make("latch_inside",'Защелка изнутри')->render(fn (DoorsLockModel $model) => $model->latch_inside?"Да":"Нет"),
            Sight::make("rods",'Наличие тяг')->render(fn (DoorsLockModel $model) => $model->rods?"Да":"Нет"),
            Sight::make("center_distance",'Межосевое расстояние - мм'),
            Sight::make("backset",'Бэксет (удаление ключевого отверстия) - мм'),
            Sight::make("end_strip_length",'Длина торцевой планки - мм'),
            Sight::make("end_strip_width",'Ширина торцевой планки - мм'),
            Sight::make("center_distance_fastenings",'Межосевое расстояние креплений замка - мм'),
            Sight::make("crossbar_diameter",'Диаметр ригеля(Высота если квадратный) - мм'),
            Sight::make("deadbolt_overhang",'Вылет ригеля - мм'),
            Sight::make("overhang_count",'Кол-во ригелей'),
            Sight::make("body_height",'Высота корпуса замка - мм'),
            Sight::make("case_depth",'Глубина корпуса замка - мм'),
            Sight::make("width_depth",'Ширина корпуса замка - мм'),
            Sight::make("key_type",'Тип ключа'),
            Sight::make("locking_from_inside",'Запирание изнутри'),
            Sight::make("attachment",'Изображения')->render(function (DoorsLockModel $model){
                $res = '';
                if ($model->attachment) {
                    foreach ($model->attachment as $attachment) {
                        $res = $res . '<a href="' . $attachment->url . '" target="_blank"><img height="200" width="250" src = "' . $attachment->url . '"></a>';
//                        $res = $res . '<img height="150" width="150" src = "' . $attachment->url . '">';
                    }
                }
                return $res;
            }),


        ];
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
