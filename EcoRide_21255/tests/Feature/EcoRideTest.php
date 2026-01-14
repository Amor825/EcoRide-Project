<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Station;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EcoRideTest extends TestCase
{
    use RefreshDatabase; // To resetuje bazę przed każdym testem (bezpieczne)

    // TEST 1: Czy strona główna działa?
    public function test_homepage_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    // TEST 2: Czy można stworzyć użytkownika?
    public function test_user_can_be_created(): void
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'role' => 'client'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com'
        ]);
    }

    // TEST 3: Czy Admin widzi swój panel?
    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Udajemy zalogowanego admina
        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200); // 200 = OK
    }

    // TEST 4: Czy Klient NIE MOŻE wejść do panelu admina? (Bezpieczeństwo)
    public function test_client_cannot_access_admin_dashboard(): void
    {
        $client = User::factory()->create(['role' => 'client']);

        $response = $this->actingAs($client)->get('/admin');

        $response->assertStatus(403); // 403 = Zabronione (Forbidden)
    }

    // TEST 5: Czy można dodać hulajnogę do bazy?
    public function test_vehicle_can_be_created(): void
    {
        // Musimy mieć stację, żeby przypisać hulajnogę
        $station = Station::create(['name' => 'Test Station', 'address' => 'Test Address', 'capacity' => 10]);

        Vehicle::create([
            'model' => 'Test Scooter',
            'station_id' => $station->id,
            'price_per_minute' => 0.50,
            'battery_level' => 100,
            'is_available' => true
        ]);

        $this->assertDatabaseHas('vehicles', [
            'model' => 'Test Scooter'
        ]);
    }
}