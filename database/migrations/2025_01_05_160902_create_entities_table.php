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
        Schema::create('entities', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('world_tile_id')->unique(); // One entity per tile
            $table->string('type'); // e.g., plant, chest
            $table->string('state')->nullable(); // e.g., growth stage

            $table->timestamps();

            $table->foreign('world_tile_id')->references('id')->on('world_tiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};
