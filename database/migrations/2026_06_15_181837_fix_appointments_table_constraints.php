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
       Schema::table('appointments', function (Blueprint $table) {

            $table->dropForeign(['schedule_id']);

        });

        Schema::table('appointments', function (Blueprint $table) {

            $table->dropUnique('appointments_schedule_id_unique');

        });

        Schema::table('appointments', function (Blueprint $table) {

            $table->foreign('schedule_id')
                ->references('id')
                ->on('teacher_schedules')
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {

            $table->unique('schedule_id');
        });
    }
};
