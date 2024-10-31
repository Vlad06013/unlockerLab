<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Valibool\TelegramConstruct\Models\Relation\Messagable;

class DoorsLockMark extends Model
{
    use HasFactory, AsSource, Filterable, Messagable;

    protected $fillable = [
        "name",
    ];

    public function inputQueryFilter():string|null {
        return null;
    }
}
