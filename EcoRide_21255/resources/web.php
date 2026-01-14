<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

// Strona Główna (to tutaj wywoływany jest widok 'home')
Route::get('/', function () {
    return view('home');
})->name('home');

// Strefa logowania
Route::middleware('auth')->group(function () {
    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/vehicles/rent/{id}', [VehicleController::class, 'rent'])->name('vehicles.rent');
    Route::post('/vehicles/rent', [VehicleController::class, 'storeRent'])->name('vehicles.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';