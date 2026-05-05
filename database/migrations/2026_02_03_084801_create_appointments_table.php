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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users','id')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers','id')->cascadeOnDelete();
            $table->foreignId('schedule_id')->constrained('teacher_schedules','id')->cascadeOnDelete();
            $table->enum('status', ['pending','accepted','rejected','cancelled'])->default('pending');
            $table->unique(['schedule_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
