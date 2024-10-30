<?php

namespace App\Orchid\Screens\DoorsLocks;

use App\Models\DoorsLockMark;
use App\Models\DoorsLockModel;
use App\Orchid\Layouts\DoorsLocks\DoorsLockModelsListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DoorsLockModelScreen extends Screen
{

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(DoorsLockMark $doorsLockMark): iterable
    {
        $this->doorsLockMark = $doorsLockMark;
        $this->doorsLockModel = DoorsLockModel::where("doors_lock_mark_id", $doorsLockMark->id)->get();
        return [
            'doorsLockModel' => $this->doorsLockModel
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Модели входных замков ' . isset($this->doorsLockMark) ? $this->doorsLockMark->name : null;
    }

    /**
     * @return string|null
     */
//    public function description(): ?string
//    {
//        return 'Examples for creating a wide variety of forms.';
//    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавить')
                ->modal('addDoorLockModel')
                ->modalTitle('Добавить модель')
                ->method('addDoorLockModel')
                ->parameters(["doorsLockMark" => $this->doorsLockMark->id])
                ->type(Color::DARK)
                ->icon('full-screen'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            DoorsLockModelsListLayout::class,
            Layout::modal('addDoorLockModel', [
                Layout::rows([
                    Input::make("name")->title("Название")->type("text"),
                    SimpleMDE::make("description")->title("Описание"),
                    Upload::make("attachment")->title("Вложения")
                ]),
            ]),
            Layout::modal('editDoorsLockModel', [
                Layout::rows([
                    Input::make("name")->title("Название")->type("text"),
                    SimpleMDE::make("description")->title("Описание"),
                    Upload::make("attachment")->title("Вложения")

                ]),
            ])->async('asyncGetCarModel'),
        ];
    }

    public function asyncGetCarModel(DoorsLockMark $doorsLockMark, DoorsLockModel $doorsLockModel): array
    {
        $this->doorsLockMark = $doorsLockMark;
        return [
            'name' => $doorsLockModel->name,
            'description' => $doorsLockModel->description,
            'attachment' => $doorsLockModel->attachment,
        ];
    }

    /**
     * @return void
     */
    public function buttonClickProcessing(): void
    {
        Toast::warning('Click Processing');
    }

    public function addDoorLockModel(Request $request): void
    {
        $data = $request->all();
        if (isset($data['name'])) {
            if (DoorsLockModel::where('name', mb_strtoupper(trim($data['name'])))->exists()) {
                Toast::error('Такая марка уже существует');
                return;
            } else {
                $doorLock = DoorsLockModel::create([
                    'name' => mb_strtoupper(trim($data['name'])),
                    'description' => isset($data['description']) ? $data['description'] : null,
                    'doors_lock_mark_id' => $data['doorsLockMark'],
                ]);

                $doorLock->makeButtonListFromItems("Модели дверных замков", null, "name", "id");

                if (isset($data['attachment'])) {
                    $doorLock->attachment()->sync($data['attachment']);
                } else {
                    $doorLock->attachment()->sync([]);
                }
            }
        }

        Toast::success('Добавлена марка ' . $data['name']);
    }

    public function editDoorsLockModel(Request $request, DoorsLockModel $doorsLockModel): void
    {
        $data = $request->all();
        if (isset($data['attachment'])) {
            $doorsLockModel->attachment()->sync($data['attachment']);
        } else {
            $doorsLockModel->attachment()->sync([]);
        }
        $doorsLockModel->name = mb_strtoupper(trim($data['name']));
        $doorsLockModel->description = isset($data['description']) ? $data['description'] : '';
        $doorsLockModel->save();
        Toast::success('Добавлена марка ' . $data['name']);
    }
}
