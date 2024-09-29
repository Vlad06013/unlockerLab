<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class CarModel extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        "name",
        "car_mark_id",
        "description",
    ];
    public function carMark()
    {
        return $this->belongsTo(CarMark::class, "car_mark_id","id");
    }


}
