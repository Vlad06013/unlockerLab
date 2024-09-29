<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;

class DoorsLockModel extends Model
{
    use HasFactory, Attachable;
    protected $fillable = [
        "name",
        "doors_lock_mark_id",
        "description",
    ];
    public function carMark()
    {
        return $this->belongsTo(DoorsLockMark::class, "doors_lock_mark_id","id");
    }

}
