<?php

namespace Valibool\TelegramConstruct\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TgUserMessageHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'bot_id',
        'last_message_id',
        'last_tg_message_id',
        'last_query_filter',
    ];
}
