<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // To jest kluczowe! Bez tego Laravel ignoruje zapisywanie danych.
    protected $fillable = [
        'user_id', 
        'vehicle_id', 
        'rating', 
        'comment', 
        'is_fixed'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}