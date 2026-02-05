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
        if (!Schema::hasTable('monthly_submissions')) {
            Schema::create('monthly_submissions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('trainee_id')->constrained('trainees')->onDelete('cascade');
                $table->integer('month'); // 1-12
                $table->integer('year'); // e.g., 2026
                $table->boolean('is_read')->default(false); // HR notification read status
                $table->timestamps();

                // Ensure one submission per trainee per month/year
                $table->unique(['trainee_id', 'month', 'year']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_submissions');
    }
};
