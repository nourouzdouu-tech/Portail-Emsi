<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name', 'description', 'type', 'owner_id'
    ];

    protected $casts = [
        'owner_id' => 'integer',
    ];

    // Constantes pour les types de groupe
    const TYPE_PUBLIC = 'public';
    const TYPE_PRIVATE = 'private';

    // Relations
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function medias()
    {
        return $this->hasMany(Media::class);
    }

    // Méthodes utilitaires
    public function isPublic()
    {
        return $this->type === self::TYPE_PUBLIC;
    }

    public function isMember(User $user)
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }

    public function scopePublic($query)
    {
        return $query->where('type', self::TYPE_PUBLIC);
    }

    public function scopeAccessibleBy($query, User $user)
    {
        return $query->where('type', self::TYPE_PUBLIC)
            ->orWhere(function($q) use ($user) {
                $q->where('type', self::TYPE_PRIVATE)
                  ->whereHas('members', function($q) use ($user) {
                      $q->where('user_id', $user->id);
                  });
            });
    }
}