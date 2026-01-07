<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'template', 'first_name', 'last_name', 'email', 
        'phone', 'job_title', 'profile', 'experiences', 'skills', 
        'status', 'name', 'address', 'city', 'formations'
    ];

    protected $casts = [
        'experiences' => 'array',
        'formations' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}