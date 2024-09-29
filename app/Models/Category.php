<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Category extends Model
{
    use HasFactory, AsSource, Filterable;
    protected $fillable = [
        "name",
        "subcategory_id"
    ];

    public function subcategory()
    {
        return $this->hasOne(Category::class, "id", "subcategory_id");
    }
}
