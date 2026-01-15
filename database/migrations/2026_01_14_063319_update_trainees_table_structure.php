<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainees', function (Blueprint $table) {
            // Only add user_id if it doesn't exist yet
            if (!Schema::hasColumn('trainees', 'user_id')) {
                $table->foreignId('user_id')->after('id')->nullable()->constrained()->onDelete('cascade');
            }
            
            // Safe removal of old columns
            if (Schema::hasColumn('trainees', 'password')) {
                $table->dropColumn(['password']);
            }
            if (Schema::hasColumn('trainees', 'remember_token')) {
                $table->dropColumn(['remember_token']);
            }
        });
    }

    public function down(): void
    {
        Schema::table('trainees', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->string('password')->nullable();
            $table->rememberToken();
        });
    }
};