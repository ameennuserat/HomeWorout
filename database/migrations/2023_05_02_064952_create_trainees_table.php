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
        Schema::create('trainees', function (Blueprint $table) {
            $table->id();
            $table->integer('weight');
            $table->integer('tall');
            $table->string('target');
            $table->string('level')->nullable();
            $table->string('target_musle')->nullable();
            $table->string('target_weight');
            $table->string('age');
            $table->string('gender');
            $table->string('illness')->nullable();
            $table->string('days_number');
            $table->integer('has_sale');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainees');
    }
};
