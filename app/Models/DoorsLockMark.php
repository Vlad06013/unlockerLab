<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Valibool\TelegramConstruct\Models\Relation\Messagable;

class DoorsLockMark extends Model
{
    use HasFactory, Messagable;

    protected $fillable = [
        "name",
    ];

    public function inputQueryFilter():string|null {
        return null;
    }
}
