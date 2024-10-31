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
        "lock_type_id",
        "lock_mech_secret_type_id",
        "secret_type",
        "resistance_class",
        "tail_latch",
        "latch_inside",
        "rods",
        "center_distance",
        "backset",
        "end_strip_length",
        "end_strip_width",
        "center_distance_fastenings",
        "crossbar_diameter",
        "deadbolt_overhang",
        "overhang_count",
        "body_height",
        "case_depth",
        "width_depth",
        "locking_from_inside",
        "key_type",
    ];
    public function mark()
    {
        return $this->belongsTo(DoorsLockMark::class, "doors_lock_mark_id","id");
    }

    public function inputQueryFilter():string|null {
        return "doors_lock_mark_id";
    }

    public function lockType()
    {
        return $this->belongsTo(LockType::class);
    }
    public function lockMechSecretType()
    {
        return $this->belongsTo(LockMechSecretType::class);
    }
}
