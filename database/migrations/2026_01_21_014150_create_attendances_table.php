<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
    $table->id();
    // Links to the trainee
    $table->foreignId('trainee_id')->constrained('trainees')->onDelete('cascade');
    
    $table->date('date'); // e.g., 2024-05-20
    $table->time('clock_in'); // e.g., 08:30:00
    $table->time('clock_out')->nullable();
    
    // Status for supervisor approval
    // Options: 'pending', 'approved', 'rejected'
    $table->string('status')->default('pending'); 
    
    // Who approved it (links to the users table)
    $table->foreignId('approved_by')->nullable()->constrained('users'); 
    
    $table->text('remarks')->nullable(); // For rejection reasons
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
