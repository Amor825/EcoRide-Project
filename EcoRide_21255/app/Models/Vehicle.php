<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'model', 
        'battery_level', 
        'is_available', 
        'price_per_minute', 
        'station_id'
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function tickets()
    {
        return $this->hasMany(MaintenanceTicket::class);
    }

    // --- NOWA FUNKCJA: POBIERA AKTYWNE WYPOŻYCZENIE ---
    public function activeRental()
    {
        return $this->hasOne(Rental::class)
                    ->where('end_time', '>', now()) // Tylko te, które się jeszcze nie skończyły
                    ->latest();
    }
}