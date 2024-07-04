<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identifier',
        'username',
        'email',
        'bio',
        'phone',
        'banner_picture',
        'profile_picture',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'private_key',
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
        ];
    }



    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            // Hash password
            $model->password = bcrypt($model->password);
            $model->private_key = strval(bin2hex(random_bytes(32)));

            if ($model->profile_picture == null) {
                $model->profile_picture = 'https://ui-avatars.com/api/?name=' . urlencode($model->username) . "&color=ffffff&background=333&bold=true&uppercase=true&size=512";
            }

            if ($model->banner_picture == null) {
                $model->banner_picture = "https://api.dicebear.com/8.x/icons/svg?seed=Milo&backgroundType=solid,gradientLinear";
            }
        });

        static::updating(function ($model) {
            // Hash password
            if ($model->isDirty('password')) {
                $model->password = bcrypt($model->password);
            }
        });
    }

    public function getFinishedAtAttribute($value)
    {
        return Carbon::parse($value)->toIso8601String();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->toIso8601String();
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
            "private_key" => $this->private_key,
        ];
    }

    /**
     * Get the posts for the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }
    /**
     * Get the comments for the user.
     */
    public function comments()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }
    /**
     * Get the likes for the user.
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id', 'id');
    }

    /**
     * Get the upvotes for the user.
     */

    public function upvotes()
    {
        return $this->hasMany(Upvote::class, 'user_id', 'id');
    }



    /**
     * Get the followers for the user.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'follower_id');
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'friends', 'follower_id', 'user_id');
    }

    public function isFollowing($userId)
    {
        return $this->follows()->where('user_id', $userId)->exists();
    }
}
