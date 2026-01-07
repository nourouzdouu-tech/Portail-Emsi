<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';
     
    protected $fillable = [
        'title', 'description', 'file_path', 'file_type', 'file_size', 
        'user_id', 'group_id', 'is_public' // Ajoutez is_public
    ];

    protected $casts = [
        'file_size' => 'integer',
        'user_id' => 'integer',
        'group_id' => 'integer',
        'is_public' => 'boolean', // Ajoutez ce cast
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function sharedWith()
    {
        return $this->belongsToMany(User::class, 'media_shares')->withTimestamps();
    }

    // Méthodes utilitaires
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeAccessibleBy($query, User $user)
    {
        return $query->where('is_public', true)
            ->orWhere('user_id', $user->id)
            ->orWhereHas('sharedWith', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->orWhereHas('group', function($q) use ($user) {
                $q->where('type', Group::TYPE_PUBLIC)
                  ->orWhereHas('members', function($q) use ($user) {
                      $q->where('user_id', $user->id);
                  });
            });
    }
}