<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Station;
use App\Models\Vehicle;
use App\Models\Rental;
// use App\Models\Payment; // <-- WYWALONE
use App\Models\Review;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        try {
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            User::truncate();
            Station::truncate();
            Vehicle::truncate();
            Rental::truncate();
            // Payment::truncate(); // <-- WYWALONE
            Review::truncate();
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } catch (\Exception $e) {
            User::query()->delete();
            Station::query()->delete();
            Vehicle::query()->delete();
            Rental::query()->delete();
            // Payment::query()->delete(); // <-- WYWALONE
            Review::query()->delete();
        }

        User::create(['name' => 'Administrator', 'email' => 'admin@ecoride.com', 'password' => Hash::make('Admin123!'), 'role' => 'admin']);
        User::create(['name' => 'Mechanik', 'email' => 'mechanik@ecoride.com', 'password' => Hash::make('Mechanik123!'), 'role' => 'mechanic']);
        $client = User::create(['name' => 'Jan Kowalski', 'email' => 'klient@ecoride.com', 'password' => Hash::make('Klient123!'), 'role' => 'client']);

        $s1 = Station::create(['name' => 'Rynek Główny', 'address' => 'Rynek 1', 'capacity' => 50]);
        $s2 = Station::create(['name' => 'Politechnika', 'address' => 'Piotrowo 3', 'capacity' => 30]);
        $s3 = Station::create(['name' => 'Dworzec Główny', 'address' => 'Dworcowa 1', 'capacity' => 40]);
        $s4 = Station::create(['name' => 'Malta', 'address' => 'Wiankowa 3', 'capacity' => 20]);

        $stations = [$s1, $s2, $s3, $s4];
        $models = ['Xiaomi Pro 2', 'Segway Ninebot', 'Lime Gen4', 'Bolt Cruiser'];

        for ($i = 1; $i <= 20; $i++) {
            $randomStation = $stations[array_rand($stations)];
            $randomModel = $models[array_rand($models)];
            Vehicle::create([
                'model' => $randomModel . ' #' . $i,
                'battery_level' => rand(20, 100),
                'is_available' => true,
                'price_per_minute' => rand(40, 90) / 100,
                'station_id' => $randomStation->id
            ]);
        }

        $brokenVehicle = Vehicle::create(['model' => 'Złombol 2000 (TEST AWARII)', 'battery_level' => 0, 'is_available' => false, 'price_per_minute' => 0.10, 'station_id' => $s1->id]);
        Review::create(['user_id' => $client->id, 'vehicle_id' => $brokenVehicle->id, 'rating' => 1, 'comment' => 'Urwane koło!', 'is_fixed' => false]);

        $v1 = Vehicle::first();
        $rental = Rental::create(['user_id' => $client->id, 'vehicle_id' => $v1->id, 'start_time' => now()->subDays(2), 'end_time' => now()->subDays(2)->addMinutes(30), 'total_cost' => 15.50]);

        // PŁATNOŚĆ WYWALONA
        // Payment::create([...]); 

        Review::create(['user_id' => $client->id, 'vehicle_id' => $v1->id, 'rating' => 5, 'comment' => 'Super sprzęt!', 'is_fixed' => true]);
    }
}