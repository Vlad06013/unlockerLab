<?php

namespace Valibool\TelegramConstruct\Models;

use Illuminate\Database\Eloquent\Model;
use Valibool\TelegramConstruct\Models\Relation\SyncableModel;

class Keyboard extends SyncableModel
{

    protected $fillable = [
        'name',
        'message_id',
        'resize_keyboard',
        'one_time_keyboard',
        'key_to_button_callback_data',
        'key_to_button_text',
        'table_name',
        'input_filter_field',
    ];
    protected $with = ['buttons'];

    public function buttons()
    {
        return $this->hasMany(Button::class)->orderBy('id');
    }
    public function message()
    {
        return $this->belongsTo(Message::class);
    }
    public function isDynamic() : bool
    {
        return (bool) $this->model_class;
    }

    public function connectedModel()
    {
        return app($this->model_class);
    }
}

