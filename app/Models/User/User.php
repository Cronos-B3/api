<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Status;
use App\Models\Card\Card;
use App\Models\UserCardInfo;
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
        "u_firstname",
        "u_lastname",
        "u_birthdate",
        "u_password",
        "u_status",
    ];

    protected $hidden = [
        "u_password",
        "u_salt",
        "u_private_key",
        "u_created_at",
        "u_updated_at",
    ];

    protected $attributes = [
        "u_firstname" => null,
        "u_lastname" => null,
        "u_birthdate" => null,
        "u_salt" => null,
        "u_role" => "ROLE_USER",
        "u_status" => Status::PENDING,
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
            if ($model->u_password != null) {
                $model->u_password = bcrypt($model->u_password);
            }
        });
    }

    public function userEmails()
    {
        return $this->hasMany(UserEmail::class, 'ue_fk_user_id', 'u_id')->where('ue_status', "!=", Status::DELETED);
    }

    public function cards()
    {
        return $this->hasMany(Card::class, 'c_fk_user_id', 'u_id')->where('c_status', "!=", Status::DELETED);
    }

    public function userBalance()
    {
        return $this->hasOne(UserBalance::class, 'ub_fk_user_id', 'u_id');
    }

    public function userCardsInfo()
    {
        return $this->hasMany(UserCardInfo::class, 'uci_fk_user_id', 'u_id');
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
}
