<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'capacity'];

    // Relacja: Stacja ma wiele pojazdów
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}