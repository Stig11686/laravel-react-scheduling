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
        Schema::table('learners', function (Blueprint $table) {
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('mentor_id')->nullable();

            $table->foreign('manager_id')->references('id')->on('users');
            $table->foreign('mentor_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learners', function (Blueprint $table) {
            //
        });
    }
};
