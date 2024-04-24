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
        Schema::create('runes', function (Blueprint $table) {
            $table->id();
            $table->text('image_path')->fullText()->nullable();
            $table->string('name')->index();
            $table->string('rarity')->index();
            $table->text('effect')->fullText();
            $table->integer('dust')->default(0);
            $table->integer('andermant')->default(0);
            $table->integer('draken')->default(0);
            $table->integer('materi_fragment')->default(0);
            $table->integer('gilded_clover')->default(0);
            $table->json('upgrading_cost')->nullable();
            $table->json('melting_cost')->nullable();
            $table->json('selling_cost')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('runes');
    }
};
