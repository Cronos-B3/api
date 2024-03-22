<?php

namespace App\Models;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CronLike extends Model
{
    use HasFactory;

    protected $table = 'cron_like';
    const PREFIX = 'cl_';
    public $incrementing = false;
    protected $primaryKey = 'cl_id';
    protected $keyType = 'string';
    const CREATED_AT = 'cl_created_at';
    const UPDATED_AT = 'cl_updated_at';

    protected $fillable = [
        "cl_fk_cron_id",
    ];

    protected $hidden = [
        "cl_id",
        "cl_fk_cron_id",
        "cl_created_at",
        "cl_updated_at",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'cl_fk_user_id', 'u_id');
    }

    public function cron()
    {
        return $this->belongsTo(Cron::class, 'cl_fk_cron_id', 'c_id');
    }
}
