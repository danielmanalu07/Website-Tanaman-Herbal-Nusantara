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
        Schema::create('news_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained('news')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title');
            $table->text('content');
            $table->timestamps();

            $table->unique(['news_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_languages');
    }
};
