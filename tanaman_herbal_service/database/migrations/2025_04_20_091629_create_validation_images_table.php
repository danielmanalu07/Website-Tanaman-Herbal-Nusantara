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
        Schema::create('validation_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('validation_id');
            $table->unsignedBigInteger('image_id');
            $table->foreign('validation_id')->references('id')->on('plant_validations')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validation_images');
    }
};
