<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\User;
use App\Models\Review;
use App\Models\Rental;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    // --- STRONA ADMINA ---
    public function admin()
    {
        // 1. Statystyki
        $stats = [
            'users' => User::count(),
            'vehicles' => Vehicle::count(),
            'rentals' => Rental::count(),
        ];
        
        $latestUsers = User::latest()->take(5)->get();
        $reviews = Review::with(['user', 'vehicle'])->latest()->take(5)->get();

        $allUsers = User::all();
        $allVehicles = Vehicle::with('station')->get();
        $stations = Station::all();

        return view('admin.dashboard', compact('stats', 'latestUsers', 'reviews', 'allUsers', 'allVehicles', 'stations'));
    }

    // --- ZARZĄDZANIE UŻYTKOWNIKAMI ---
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,mechanic,client'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return back()->with('success', 'Dodano nowego użytkownika!');
    }
    // --- NOWA METODA: EDYCJA UŻYTKOWNIKA (ZMIANA ROLI) ---
    public function updateUser(Request $request, $id)
    {
        // 1. Zabezpieczenie: Nie możesz edytować samego siebie
        if ((int)$id === auth()->id()) {
            return back()->with('error', 'Nie możesz zmienić uprawnień samemu sobie!');
        }

        $user = User::findOrFail($id);

        // 2. Walidacja
        $request->validate([
            'role' => 'required|in:admin,mechanic,client'
        ]);

        // 3. Aktualizacja
        $user->update(['role' => $request->role]);

        return back()->with('success', "Zmieniono rolę użytkownika {$user->name} na " . strtoupper($request->role));
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Nie możesz usunąć samego siebie!');
        }
        $user->delete();
        return back()->with('success', 'Użytkownik został usunięty.');
    }

    // --- ZARZĄDZANIE POJAZDAMI ---
    public function storeVehicle(Request $request)
    {
        $request->validate([
            'model' => 'required|string',
            'station_id' => 'required|exists:stations,id',
            'price_per_minute' => 'required|numeric|min:0',
            'battery_level' => 'required|integer|min:0|max:100'
        ]);

        Vehicle::create([
            'model' => $request->model,
            'station_id' => $request->station_id,
            'price_per_minute' => $request->price_per_minute,
            'battery_level' => $request->battery_level,
            'is_available' => true
        ]);

        return back()->with('success', 'Dodano nową hulajnogę!');
    }

    public function updateVehiclesBulk(Request $request)
    {
        $data = $request->validate([
            'vehicles' => 'required|array',
            'vehicles.*.model' => 'required|string',
            'vehicles.*.price_per_minute' => 'required|numeric|min:0',
            'vehicles.*.battery_level' => 'required|integer|min:0|max:100',
        ]);

        $count = 0;
        foreach ($data['vehicles'] as $id => $attributes) {
            $vehicle = Vehicle::find($id);
            if ($vehicle) {
                $vehicle->update($attributes);
                $count++;
            }
        }
        return back()->with('success', "Zaktualizowano $count pojazdów.");
    }

    public function destroyVehicle($id)
    {
        Vehicle::findOrFail($id)->delete();
        return back()->with('success', 'Pojazd usunięty.');
    }

    // --- STRONA MECHANIKA ---
    public function mechanic()
    {
        $reports = Review::with(['vehicle', 'user'])
                    ->where('is_fixed', false)
                    ->where('rating', '<=', 2)
                    ->latest()
                    ->get();

        $vehicles = Vehicle::orderBy('id')->get();

        return view('mechanic.dashboard', compact('reports', 'vehicles'));
    }

    public function chargeSingle(Request $request, $id)
    {
        $request->validate(['amount' => 'required|integer|min:1']);
        $vehicle = Vehicle::findOrFail($id);
        
        if ($request->amount == 100) $vehicle->battery_level = 100;
        else $vehicle->battery_level = min(100, $vehicle->battery_level + $request->amount);

        $vehicle->save();
        return back()->with('success', "Naładowano hulajnogę #{$vehicle->id} (Stan: " . round($vehicle->battery_level) . "%)");
    }
    
    // Puste funkcje (zastępniki) dla starego routingu updateVehicle (jeśli gdzieś został)
    public function updateVehicle(Request $request, $id) { return back(); }
}