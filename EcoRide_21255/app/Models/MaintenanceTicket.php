<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceTicket extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_id', 'description', 'issue_description', 'status', 'request_date', 'is_resolved'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}