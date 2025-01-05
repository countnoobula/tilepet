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
        Schema::create('noobs', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->integer('position_x')->default(0);
            $table->integer('position_y')->default(0);
            $table->integer('hunger')->default(100);
            $table->integer('thirst')->default(100);
            $table->integer('social')->default(50);

            // Skills
            $table->integer('strength')->default(1);
            $table->integer('perception')->default(1);
            $table->integer('endurance')->default(1);
            $table->integer('charisma')->default(1);
            $table->integer('intelligence')->default(1);
            $table->integer('agility')->default(1);
            $table->integer('luck')->default(1);

            // Inventory Relationship
            $table->unsignedBigInteger('inventory_id')->nullable();
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noobs');
    }
};
