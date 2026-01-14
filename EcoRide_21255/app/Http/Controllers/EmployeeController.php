<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceTicket;
use App\Models\Review;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    /**
     * Dashboard pracownika
     */
    public function dashboard(): View
    {
        $maintenanceTickets = MaintenanceTicket::with('vehicle')->get();
        $recentReviews = Review::with('user', 'vehicle')->latest()->limit(10)->get();

        return view('employee.dashboard', [
            'maintenanceTickets' => $maintenanceTickets,
            'recentReviews' => $recentReviews,
        ]);
    }
}
