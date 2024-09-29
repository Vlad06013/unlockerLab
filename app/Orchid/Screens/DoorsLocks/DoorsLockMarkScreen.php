<?php

namespace App\Orchid\Screens\DoorsLocks;

use App\Models\CarMark;
use App\Models\DoorsLockMark;
use App\Orchid\Layouts\Cars\CarMarksListLayout;
use App\Orchid\Layouts\DoorsLocks\DoorsLockMarksListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DoorsLockMarkScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $this->doorsLockMark = DoorsLockMark::all();
        return [
            'doorsLockMark' => $this->doorsLockMark
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Марки дверных замков';
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
                ->modal('addDoorsLockMark')
                ->modalTitle('Добавить марку')
                ->method('addDoorsLockMark')
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
            DoorsLockMarksListLayout::class,
            Layout::modal('addDoorsLockMark', [
                Layout::rows([
                    Input::make("name")->title("Название")->type("text"),
                ]),
            ]),
        ];
    }

    /**
     * @return void
     */
    public function buttonClickProcessing(): void
    {
        Toast::warning('Click Processing');
    }

    public function addDoorsLockMark(Request $request): void
    {
        $data = $request->all();
        if(isset($data['name'])){
            if(DoorsLockMark::where('name', mb_strtoupper(trim($data['name'])))->exists()){
                Toast::error('Такая марка уже существует');
                return;
            } else {
                DoorsLockMark::create([
                    'name' => mb_strtoupper(trim($data['name'])),
                ]);
            }
        }

        Toast::success('Добавлена марка '.$data['name']);
    }
}
