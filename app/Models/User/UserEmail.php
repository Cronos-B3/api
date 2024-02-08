<?php

namespace App\Models\User;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEmail extends Model
{
    use HasFactory;

    protected $table = 'user_email';
    const PREFIX = 'ue_';
    protected $primaryKey = 'ue_id';
    const CREATED_AT = 'ue_created_at';
    const UPDATED_AT = 'ue_updated_at';

    protected $fillable = [
        "ue_fk_user_id",
        "ue_email",
        "ue_primary",
        "ue_status",
    ];

    protected $hidden = [
        "ue_id",
        "ue_fk_user_id",
        "ue_created_at",
        "ue_updated_at",
    ];

    protected $attributes = [
        "ue_primary" => false,
        "ue_status" => Status::PENDING,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ue_fk_user_id', 'u_id');
    }
}
