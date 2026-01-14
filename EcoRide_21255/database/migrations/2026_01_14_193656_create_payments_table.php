<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            // Płatność dotyczy konkretnego wypożyczenia
            $table->foreignId('rental_id')->constrained()->onDelete('cascade');
            
            $table->decimal('amount', 8, 2);
            $table->dateTime('payment_date');
            $table->string('method')->default('Karta'); // Metoda płatności
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};