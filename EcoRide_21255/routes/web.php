<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Strona Główna
Route::get('/', function () {
    return view('home');
})->name('home');

// DLA ZALOGOWANYCH (Wspólne dla wszystkich)
Route::middleware('auth')->group(function () {
    
    // 1. POJAZDY (Lista, Wypożyczanie, Zapis Wypożyczenia)
    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/vehicles/rent/{id}', [VehicleController::class, 'rent'])->name('vehicles.rent');
    Route::post('/vehicles/rent', [VehicleController::class, 'storeRent'])->name('vehicles.store');

    // 2. OPINIE (Zgłaszanie usterek)
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // 3. PROFILE (Domyślne z Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// PANEL MECHANIKA
Route::middleware(['auth', 'role:mechanic'])->group(function () {
    Route::get('/mechanic', [DashboardController::class, 'mechanic'])->name('mechanic.dashboard');
    Route::post('/mechanic/fix/{id}', [ReviewController::class, 'markAsFixed'])->name('mechanic.fix');
    
    // Masowe zarządzanie
    Route::post('/mechanic/bulk', [DashboardController::class, 'bulkUpdate'])->name('mechanic.bulk');

    // Pojedyncze ładowanie
    Route::post('/mechanic/charge/{id}', [DashboardController::class, 'chargeSingle'])->name('mechanic.charge');
});

// PANEL ADMINA
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'admin'])->name('admin.dashboard');
    
    // Zarządzanie Użytkownikami
    Route::post('/admin/users', [DashboardController::class, 'storeUser'])->name('admin.users.store');
    // NOWA TRASA DO ZMIANY ROLI:
    Route::put('/admin/users/{id}', [DashboardController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [DashboardController::class, 'destroyUser'])->name('admin.users.destroy');

    // Zarządzanie Pojazdami
    Route::post('/admin/vehicles', [DashboardController::class, 'storeVehicle'])->name('admin.vehicles.store');
    Route::put('/admin/vehicles/bulk', [DashboardController::class, 'updateVehiclesBulk'])->name('admin.vehicles.bulk');
    Route::delete('/admin/vehicles/{id}', [DashboardController::class, 'destroyVehicle'])->name('admin.vehicles.destroy');
});

require __DIR__.'/auth.php';