<?php

namespace Valibool\TelegramConstruct\Models\Relation;


use Valibool\TelegramConstruct\Models\Keyboard;
use Valibool\TelegramConstruct\Models\Message;

trait  Messagable
{

    abstract public function InputQueryFilter(): string|null;

    public function tgMessageable()
    {
        return $this->morphOne(TgMessagable::class, 'tg_messagable');
    }

    public function makeButtonListFromItems(
        string $messageName = null,
        string $messageText = null,
        string $keyToBtnText,
        string $keyToBtnCallback,
        int $botId = 1
    )
    {
        $message = $this->createMassage(
            $botId,
            $messageName,
            $messageText,
            $keyToBtnText,
            $keyToBtnCallback);
    }
    public function makeItemAsButton(
        string $messageName = null,
        string $messageText = null,
        string $keyToBtnText,
        string $keyToBtnCallback,
        int $botId = 1
    )
    {
        $message = $this->createMassage(
            $botId,
            $messageName,
            $messageText,
            $keyToBtnText,
            $keyToBtnCallback
        );
        $this->createMessagable($message->id);
    }


    private function createMessagable(int $messageId)
    {
        if (!$this->tgMessageable) {
            TgMessagable::create([
                'tg_messagable_type' => $this::class,
                'tg_messagable_id' => $this->id,
                'from_message_id' => $messageId,
                'callback_data' => "query_".$this->id,
            ]);
        }
    }

    private function createMassage(
        int $botId,
        string $messageName = null,
        string $messageText = null,
        $keyToBtnText,
        $keyToBtnCallback
    ): Message
    {
        $fieldFilter = $this->inputQueryFilter();
        $keyboard = Keyboard::where('table_name', $this->getTable())->first();
        if (!$keyboard) {
            $message = Message::create([
                'text' => $messageText ?? $messageName,
                'bot_id' => $botId,
                'name' => $messageName,
                'type' => 'message',
            ]);
            $message->keyboard->table_name = $this->getTable();
            $message->keyboard->key_to_button_text = mb_strtoupper(trim($keyToBtnText));
            $message->keyboard->key_to_button_callback_data = mb_strtoupper(trim($keyToBtnCallback));
            if($fieldFilter) {
                $message->keyboard->input_filter_field = $fieldFilter;
            }
            $message->keyboard->save();
            return $message;
        }
        return $keyboard->message;
    }
}
