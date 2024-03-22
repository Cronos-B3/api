<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Status;
use App\Models\Cron;
use App\Models\CronLike;
use App\Models\UpVote;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';
    const PREFIX = 'u_';
    public $incrementing = false;
    protected $primaryKey = 'u_id';
    protected $keyType = 'string';
    const CREATED_AT = 'u_created_at';
    const UPDATED_AT = 'u_updated_at';

    protected $fillable = [
        "u_role",
        "u_username",
        "u_nickname",
        "u_birthdate",
        "u_password",
        "u_email",
        "u_phone",
        "u_status",
        "u_profile_picture",
        "u_banner_picture",
    ];

    protected $hidden = [
        "u_password",
        "u_private_key",
        "u_created_at",
        "u_updated_at",
    ];

    protected $attributes = [
        "u_birthdate" => null,
        "u_role" => "ROLE_USER",
        "u_status" => Status::ACTIVE,
        "u_profile_picture" => null,
        "u_banner_picture" => null,
    ];

    protected static function boot()
    {
        parent::boot();

        // Execute before save
        static::creating(function ($model) {
            // Generate UUID for u_id and u_private_key
            $model->u_id = Str::uuid()->toString();
            $model->u_private_key = Str::uuid()->toString();

            // Hash password
            if ($model->u_password != null) {
                $model->u_password = bcrypt($model->u_password);
            }
        });

        // Execute before update
        static::updating(function ($model) {
            // Hash password
            if ($model->u_password->isDirty() && $model->u_password != null) {
                $model->u_password = bcrypt($model->u_password);
            }
        });
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'u_private_key' => $this->u_private_key,
        ];
    }

    public function crons()
    {
        return $this->hasMany(Cron::class, 'c_fk_user_id', 'u_id');
    }

    public function likes()
    {
        return $this->hasMany(CronLike::class, 'cl_fk_user_id', 'u_id');
    }

    public function upVotes()
    {
        return $this->hasMany(UpVote::class, 'uv_fk_user_id', 'u_id');
    }
}
