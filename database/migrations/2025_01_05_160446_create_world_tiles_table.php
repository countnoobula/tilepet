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
        Schema::create('world_tiles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('world_id');
            $table->integer('x');
            $table->integer('y');
            $table->string('terrain_type'); // e.g., grass, water, mountain, sand, forest
            $table->string('object_type')->nullable(); // e.g., plant, water_source, tree, rock
            $table->string('object_state')->nullable(); // e.g., growth stage for plants

            $table->timestamps();

            $table->foreign('world_id')->references('id')->on('worlds')->onDelete('cascade');

            $table->unique(['world_id', 'x', 'y']); // Ensure unique tiles per world
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('world_tiles');
    }
};
