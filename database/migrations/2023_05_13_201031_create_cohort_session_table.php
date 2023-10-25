<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cohort_session', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cohort_id')->constrained()->cascadeOnDelete();
            $table->foreignId('session_id')->constrained()->cascadeOnDelete();
            $table->dateTime('date')->nullable();
            $table->foreignId('trainer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('zoom_room_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->unique(['date', 'trainer_id', 'zoom_room_id']);
            $table->unique(['date', 'zoom_room_id']);
            $table->unique(['date', 'trainer_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cohort_session');
    }
};
