<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'user_id',
        'content',
        'finished_at',
    ];

    public function getFinishedAtAttribute($value)
    {
        return Carbon::parse($value)->toIso8601String();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->toIso8601String();
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->toIso8601String();
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Post::class, 'parent_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id', 'id');
    }

    public function upvotes()
    {
        return $this->hasMany(Upvote::class, 'post_id', 'id');
    }

    public function userLiked()
    {
        return $this->hasOne(Like::class)->where('user_id', auth()->id());
    }

    public function userUpvoted()
    {
        return $this->hasOne(Upvote::class)->where('user_id', auth()->id());
    }
}
