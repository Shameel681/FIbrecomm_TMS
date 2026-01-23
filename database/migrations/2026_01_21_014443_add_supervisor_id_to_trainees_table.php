<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('trainees', function (Blueprint $table) {
        // 1. Create the column
        // 2. constrained('users') tells Laravel it points to the users table
        // 3. nullOnDelete() ensures if a supervisor is deleted, the trainee record stays
        $table->foreignId('supervisor_id')
              ->nullable()
              ->after('user_id') 
              ->constrained('users')
              ->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('trainees', function (Blueprint $table) {
        $table->dropForeign(['supervisor_id']);
        $table->dropColumn('supervisor_id');
    });
}
};
