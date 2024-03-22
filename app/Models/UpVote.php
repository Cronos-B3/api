<?php

namespace App\Models;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpVote extends Model
{
    use HasFactory;

    protected $table = 'up_vote';
    const PREFIX = 'uv_';
    public $incrementing = false;
    protected $primaryKey = 'uv_id';
    protected $keyType = 'string';
    const CREATED_AT = 'uv_created_at';
    const UPDATED_AT = 'uv_updated_at';

    protected $fillable = [
        "uv_fk_cron_id",
    ];

    protected $hidden = [
        "uv_id",
        "uv_fk_cron_id",
        "uv_created_at",
        "uv_updated_at",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'uv_fk_user_id', 'u_id');
    }
    public function cron()
    {
        return $this->belongsTo(Cron::class, 'uv_fk_cron_id', 'c_id');
    }
}
