<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Valibool\TelegramConstruct\Models\Relation\Messagable;

class Category extends Model
{
    use HasFactory, AsSource, Filterable, Messagable;
    protected $fillable = [
        "name",
        "subcategory_id"
    ];

    public function inputQueryFilter():string|null {
        return null;
    }
    public function subcategory()
    {
        return $this->hasOne(Category::class, "id", "subcategory_id");
    }
}
