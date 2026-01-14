<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->integer('battery_level');
            $table->boolean('is_available')->default(true);
            $table->decimal('price_per_minute', 8, 2); // Cena np. 0.50
            
            // Relacja: Pojazd należy do Stacji
            $table->foreignId('station_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};