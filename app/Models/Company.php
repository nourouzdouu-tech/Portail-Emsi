<?php

// app/Models/Company.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'mission',
        'vision',
        'founded_year',
        'employees_count',
        'projects_completed',
        'clients_count',
        'logo',
        'hero_image',
        'phone',
        'email',
        'address',
        'website'
    ];

    protected $casts = [
        'founded_year' => 'integer',
        'employees_count' => 'integer',
        'projects_completed' => 'integer',
        'clients_count' => 'integer',
    ];
}