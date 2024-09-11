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
        Schema::create('fitness_plans', function (Blueprint $table) {
            $table->id();
            $table->string('day')->nullable();
            $table->boolean('done');

            $table->foreignId('trainees_id')->references('id')->on('trainees')->onDelete('cascade');
            $table->foreignId('fitnesses_id')->references('id')->on('fitness')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitness_plans');
    }
};
