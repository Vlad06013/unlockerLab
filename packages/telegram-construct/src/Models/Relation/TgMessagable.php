<?php

namespace Valibool\TelegramConstruct\Models\Relation;

use Illuminate\Database\Eloquent\Model;

class TgMessagable extends Model
{
    protected $fillable = [
        "tg_messagable_type",
        "tg_messagable_id",
        "from_message_id",
        "to_message_id",
        "callback_data",
    ];

//    public function sync()
//    {
//        dd($this);
////        if(!$model->tgMessage) {
//////            TgMessagable::create([
//////                'tg_messagable_type' => get_class($model),
//////                'tg_messagable_id' => $model->id,
//////                'from_message_id' => 1,
//////                'callback_data' => $model->id,
//////            ]);
//////        }
//    }
}
