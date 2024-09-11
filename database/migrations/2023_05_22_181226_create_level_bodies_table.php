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
        Schema::create('level_bodies', function (Blueprint $table) {
            $table->id();
            $table->string('set')->nullable();
            $table->string('repition')->nullable();
            $table->string('duration')->nullable();
            $table->string('target_muscle');
            $table->foreignId('level_id')->references('id')->on('levels')->onDelete('cascade');
            $table->foreignId('buildmuscle_id')->references('id')->on('building_muscles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_bodies');
    }
};
