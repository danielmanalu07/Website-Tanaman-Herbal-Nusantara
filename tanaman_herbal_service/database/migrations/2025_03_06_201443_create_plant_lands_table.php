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
        Schema::create('plant_lands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plant_id');
            $table->foreign('plant_id')->references('id')->on('plants')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->unsignedBigInteger('land_id');
            $table->foreign('land_id')->references('id')->on('lands')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant_lands');
    }
};
