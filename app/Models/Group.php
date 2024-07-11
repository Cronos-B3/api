<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'image',
        'creator_id',
        'description',
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->code = uniqid();
            $model->save(); // Sauvegarder le modèle avec l'URL mise à jour
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_users', 'group_id', 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }
}
