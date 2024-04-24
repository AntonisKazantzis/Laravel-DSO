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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->text('image_path')->fullText()->nullable();
            $table->string('name')->index();
            $table->integer('level')->default(0);
            $table->string('rarity')->index();
            $table->string('class')->index();
            $table->string('type')->index();
            $table->text('description')->fullText();
            $table->json('base_values')->nullable();
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
        Schema::dropIfExists('items');
    }
};
