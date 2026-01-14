<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // ZAPIS OPINII I BLOKADA USZKODZONEGO POJAZDU
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        // 1. Tworzymy opinię w bazie
        Review::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $request->vehicle_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_fixed' => false // Domyślnie usterka jest "otwarta"
        ]);

        // 2. LOGIKA AWARII: Jeśli ocena jest niska (1 lub 2), blokujemy hulajnogę!
        if ($request->rating <= 2) {
            $vehicle = Vehicle::find($request->vehicle_id);
            $vehicle->update(['is_available' => false]); // <--- TO BLOKUJE POJAZD
        }

        return back()->with('success', 'Dziękujemy! Jeśli zgłosiłeś awarię, pojazd został zablokowany.');
    }

    // NAPRAWA PRZEZ MECHANIKA
    public function markAsFixed($id)
    {
        $review = Review::findOrFail($id);
        
        // 1. Zamykamy zgłoszenie
        $review->update(['is_fixed' => true]);
        
        // 2. NAPRAWIAMY POJAZD:
        // - Odblokowujemy (Dostępna)
        // - Ładujemy baterię na MAX (100%)
        $review->vehicle->update([
            'is_available' => true, 
            'battery_level' => 100
        ]);

        return back()->with('success', 'Pojazd naprawiony i naładowany do 100%!');
    }
}