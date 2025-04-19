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
        Schema::create('habitus_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('habitus_id')->constrained('habituses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->timestamps();

            $table->unique(['habitus_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitus_languages');
    }
};
