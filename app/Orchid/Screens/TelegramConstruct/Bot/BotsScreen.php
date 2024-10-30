<?php

namespace App\Orchid\Screens\TelegramConstruct\Bot;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Telegram\Bot\Api;
use Valibool\TelegramConstruct\Models\Bot;
use Valibool\TelegramConstruct\Services\API\BotApiService;

class BotsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $this->usersBots = Bot::where('user_id', Auth::id())->get();
        return [
            'bots' => $this->usersBots
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Управление ботами';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Новый бот')
                ->modal('Новый бот')
                ->method('connectBot')
                ->icon('wallet'),
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
            Layout::modal('Новый бот', [
                Layout::rows([
                    Input::make('token')
                        ->title('Токен')
                        ->placeholder('Введите токен бота')->required(),
                ]),
            ]),
            Layout::tabs([
                'Мои боты' => [
                    Layout::rows(
                        $this->getBotsList()
                    ),
                ],
            ]),

        ];
    }
    public function getBotsList()
    {
        $botList = [];
        foreach ($this->usersBots as $bot){
//            $botList[] = Link::make($bot->name)->route('platform.screens.bots.edit.settings',['bot'=>$bot->id])->icon('wallet');
            $botList[] = Label::make($bot->name)->title($bot->name);
        }

        return $botList;
    }
//
    public function connectBot(Request $request): void
    {
        $data = $request->all();
        $token = $data['token'];
        $result = BotApiService::connectBot($token);
        if ($result->getStatusCode()== Response::HTTP_OK) {
            Toast::success('Бот подключен')
                ->autoHide(true);
        } else {
            Toast::error('Бот не найден')
                ->autoHide(true);
        }
    }
}
