<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Rental;
// use App\Models\Payment; // <-- WYWALONE
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VehicleController extends Controller
{
    public function index()
    {
        // A. PĘTLA ZUŻYCIA BATERII
        $activeRentals = Rental::where('end_time', '>', Carbon::now())
            ->whereHas('vehicle', function($q) {
                $q->where('is_available', false);
            })
            ->with('vehicle')
            ->get();

        foreach ($activeRentals as $rental) {
            $vehicle = $rental->vehicle;
            $minutesPassed = $vehicle->updated_at->diffInMinutes(Carbon::now());

            if ($minutesPassed >= 1) {
                $newBattery = $vehicle->battery_level - $minutesPassed;
                $vehicle->battery_level = max(0, $newBattery);
                $vehicle->save();
            }
        }

        // B. AUTO-ODBLOKOWANIE
        $expiredRentals = Rental::where('end_time', '<', Carbon::now())
            ->whereHas('vehicle', function($q) {
                $q->where('is_available', false);
            })
            ->get();

        foreach ($expiredRentals as $rental) {
            $hasActiveRental = Rental::where('vehicle_id', $rental->vehicle_id)
                                     ->where('end_time', '>', Carbon::now())
                                     ->exists();

            if ($hasActiveRental) continue;

            $hasIssues = \App\Models\Review::where('vehicle_id', $rental->vehicle_id)
                        ->where('rating', '<=', 2)
                        ->where('is_fixed', false)
                        ->exists();

            if (!$hasIssues) {
                $rental->vehicle->update(['is_available' => true]);
            }
        }

        $vehicles = Vehicle::with('station')->get();
        return view('vehicles.index', compact('vehicles'));
    }

    public function rent($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        if (!$vehicle->is_available) {
            return redirect()->route('vehicles.index')->with('error', 'Pojazd niedostępny!');
        }

        if ($vehicle->battery_level <= 5) {
            return redirect()->route('vehicles.index')->with('error', 'Bateria jest zbyt słaba na jazdę!');
        }

        return view('vehicles.rent', compact('vehicle'));
    }

    public function storeRent(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'minutes' => 'required|integer|min:1'
        ]);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $minutes = (int) $request->minutes;

        if (!$vehicle->is_available) {
            return redirect()->route('vehicles.index')->with('error', 'Ktoś Cię ubiegł!');
        }

        if ($vehicle->battery_level < $minutes) {
            return redirect()->route('vehicles.index')->with('error', 
                "Nie dasz rady! Chcesz jechać $minutes min, a bateria ma tylko {$vehicle->battery_level}%.");
        }

        // Blokada i zapis czasu
        $vehicle->is_available = false;
        $vehicle->save();

        // Obliczamy koszt tylko informacyjnie do historii, ale nie tworzymy płatności
        $cost = $vehicle->price_per_minute * $minutes;

        $rental = Rental::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $vehicle->id,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addMinutes($minutes),
            'total_cost' => $cost // Zapisujemy koszt w historii, ale nie pobieramy kasy
        ]);
        return redirect()->route('vehicles.index')->with('success', "Rozpoczęto jazdę na $minutes min!");
    }
}