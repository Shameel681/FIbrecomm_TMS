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
    Schema::create('trainee_forms', function (Blueprint $table) {
        $table->id();
        // 1-4: Personal Info
        $table->string('full_name');
        $table->string('email')->unique();
        $table->string('phone');
        $table->text('address');
        
        // 5-8: Academic
        $table->string('institution');
        $table->string('major');
        $table->string('study_level'); // diploma/degree/other
        $table->date('grad_date');
        
        // 9-12: Internship details
        $table->integer('duration');
        $table->date('start_date');
        $table->string('interest');
        $table->string('coursework_req'); // yes/no
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainee_forms');
    }
};
