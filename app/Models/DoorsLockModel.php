<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Valibool\TelegramConstruct\Models\File\Traits\Attachable;
use Valibool\TelegramConstruct\Models\Relation\Messagable;

class DoorsLockModel extends Model
{
    use HasFactory, AsSource, Filterable, Messagable, Attachable;
    protected $fillable = [
        "name",
        "doors_lock_mark_id",
        "description",
    ];
    public function carMark()
    {
        return $this->belongsTo(DoorsLockMark::class, "doors_lock_mark_id","id");
    }

    public function inputQueryFilter():string|null {
        return "doors_lock_mark_id";
    }
}
