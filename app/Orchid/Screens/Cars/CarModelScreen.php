<?php

namespace App\Orchid\Screens\Cars;

use App\Models\CarMark;
use App\Models\CarModel;
use App\Orchid\Layouts\CarModelsListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CarModelScreen extends Screen
{
    private CarMark $carMark;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(CarMark $carMark): iterable
    {
        $this->carMark = $carMark;

        $this->carModels = CarModel::where("car_mark_id", $carMark->id)->get();
        return [
            'carModels' => $this->carModels
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Модели автомобилей '.$this->carMark->name;
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
            CarModelsListLayout::class,
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
            if(CarMark::where('name', $data['name'])->exists()){
                Toast::error('Такая марка уже существует');
                return;
            } else {
                CarMark::create([
                    'name' => $data['name'],
                    'category_id' => 1,
                ]);
            }
        }

        Toast::success('Добавлена марка '.$data['name']);
    }
}
