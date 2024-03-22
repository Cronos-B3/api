<?php

namespace App\Models;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cron extends Model
{
    use HasFactory;

    protected $table = 'cron';
    const PREFIX = 'c_';
    public $incrementing = false;
    protected $primaryKey = 'c_id';
    protected $keyType = 'string';
    const CREATED_AT = 'c_created_at';
    const UPDATED_AT = 'c_updated_at';

    protected $fillable = [
        "c_fk_user_id",
        "c_fk_cron_id",
        "c_text",
        "c_chanel",
        "c_status",
        "c_end_at",
    ];

    protected $hidden = [
        "c_created_at",
        "c_updated_at",
    ];

    protected $attributes = [
        "c_status" => "ACTIVE",
    ];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->c_id = Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'c_fk_user_id', 'u_id');
    }
}
