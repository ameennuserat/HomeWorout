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
        Schema::create('commerce_trainers', function (Blueprint $table) {
            $table->id();
            $table->boolean('discount');
            $table->foreignId('trainees_id')->references('id')->on('trainees')->onDelete('cascade');
            $table->foreignId('commerce_id')->references('id')->on('commerces')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commerce_trainers');
    }
};
