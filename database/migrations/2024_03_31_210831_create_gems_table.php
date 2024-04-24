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
        Schema::create('gems', function (Blueprint $table) {
            $table->id();
            $table->text('image_path')->fullText()->nullable();
            $table->string('name')->index();
            $table->string('type')->index();
            $table->string('rarity')->index();
            $table->text('effect')->fullText();
            $table->float('value')->default(0);
            $table->integer('dust')->default(0);
            $table->integer('andermant')->default(0);
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
        Schema::dropIfExists('gems');
    }
};
