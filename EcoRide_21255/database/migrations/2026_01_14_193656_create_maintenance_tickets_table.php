<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_tickets', function (Blueprint $table) {
            $table->id();
            
            // Zgłoszenie dotyczy pojazdu
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            
            $table->text('description'); // Opis usterki
            $table->text('issue_description')->nullable(); // Alternatywna nazwa dla opisu
            $table->string('status')->default('open'); // open, in_progress, closed
            $table->dateTime('request_date');
            $table->boolean('is_resolved')->default(false); // Czy naprawione?
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_tickets');
    }
};