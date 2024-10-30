<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Valibool\TelegramConstruct\Models\Relation\Messagable;

class CarModel extends Model
{
    use HasFactory, AsSource, Filterable, Messagable;

    protected $fillable = [
        "name",
        "car_mark_id",
        "description",
    ];
    public function carMark()
    {
        return $this->belongsTo(CarMark::class, "car_mark_id","id");
    }

    public function inputQueryFilter():string|null {
        return "car_mark_id";
    }

}
