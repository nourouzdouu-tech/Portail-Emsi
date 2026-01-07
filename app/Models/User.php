<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

   /* protected $fillable = [
        'name', 'email', 'password', 'type' // candidat/recruteur/admin
    ];*/

    protected $fillable = [
    'name', 'email', 'password', 'type', 'phone', 'ville', 'about'
    ];
     
     protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    // Relation polymorphique pour le profil
    public function profile()
    {
        return $this->morphTo();
    }

    // Relations
    public function groups()
    {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }

    public function ownedGroups()
    {
        return $this->hasMany(Group::class, 'owner_id');
    }

    public function medias()
    {
        return $this->hasMany(Media::class);
    }

    public function sharedMedias()
    {
        return $this->belongsToMany(Media::class, 'media_shares')->withTimestamps();
    }

    public function sentFriendRequests()
    {
        return $this->hasMany(FriendRequest::class, 'sender_id');
    }

    public function receivedFriendRequests()
    {
        return $this->hasMany(FriendRequest::class, 'receiver_id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->withPivot('created_at')
            ->withTimestamps();
    }

    public function sentMessages()
{
    return $this->hasMany(Message::class, 'sender_id');
}

public function receivedMessages()
{
    return $this->hasMany(Message::class, 'receiver_id');
}

public function messagesWith($userId)
{
    return Message::where(function($q) use ($userId) {
            $q->where('sender_id', $this->id)
              ->where('receiver_id', $userId);
        })
        ->orWhere(function($q) use ($userId) {
            $q->where('sender_id', $userId)
              ->where('receiver_id', $this->id);
        });
}
public function candidatures()
{
    return $this->hasMany(Candidature::class);
}


}
