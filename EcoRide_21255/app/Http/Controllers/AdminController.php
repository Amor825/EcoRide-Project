<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\MaintenanceTicket;
use App\Models\Payment;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Dashboard administratora
     */
    public function dashboard(): View
    {
        $totalUsers = User::count();
        $totalVehicles = Vehicle::count();
        $maintenanceTickets = MaintenanceTicket::all();
        $payments = Payment::all();
        $users = User::all();
        $vehicles = Vehicle::all();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalVehicles' => $totalVehicles,
            'maintenanceTickets' => $maintenanceTickets,
            'payments' => $payments,
            'users' => $users,
            'vehicles' => $vehicles,
        ]);
    }

    /**
     * Zarządzanie użytkownikami
     */
    public function users(): View
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * Zarządzanie pojazami
     */
    public function vehicles(): View
    {
        $vehicles = Vehicle::with('station', 'reviews')->get();
        return view('admin.vehicles', compact('vehicles'));
    }

    /**
     * Aktualizacja roli użytkownika
     */
    public function updateUserRole(User $user, $role)
    {
        $validRoles = ['client', 'employee', 'admin'];
        
        if (!in_array($role, $validRoles)) {
            return redirect()->back()->with('error', 'Nieprawidłowa rola');
        }

        $user->update(['role' => $role]);
        return redirect()->back()->with('success', 'Rola użytkownika zaktualizowana');
    }
}
