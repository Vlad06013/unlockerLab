<?php

namespace App\Orchid\Screens\Cars;

use App\Models\CarMark;
use App\Orchid\Layouts\Cars\CarMarksListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CarMarkScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $this->carMarks = CarMark::all();
        return [
            'carMarks' => $this->carMarks
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Марки автомобилей';
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
                ->modal('addCarMark')
                ->modalTitle('Добавить марку')
                ->method('addCarMark')
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
            CarMarksListLayout::class,
            Layout::modal('addCarMark', [
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

    public function addCarMark(Request $request): void
    {
        $data = $request->all();
        if(isset($data['name'])){
            if(CarMark::where('name', mb_strtoupper(trim($data['name'])))->exists()){
                Toast::error('Такая марка уже существует');
                return;
            } else {
                CarMark::create([
                    'name' => mb_strtoupper(trim($data['name'])),
                ]);
            }
        }

        Toast::success('Добавлена марка '.$data['name']);
    }
}
