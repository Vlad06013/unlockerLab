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
        "detail_id",
    ];
    public function carMark()
    {
        return $this->hasOne(CarMark::class, "id", "car_mark_id");
    }

    public function detail()
    {
        return $this->hasOne(Detail::class);
    }
}
