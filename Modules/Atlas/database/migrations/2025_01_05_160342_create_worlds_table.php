<?php

use Modules\Atlas\Enums\Season;
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
        Schema::create('worlds', function (Blueprint $table) {
            $table->id();

            $table->string('name')->default('Unnamed');

            $table->string('season')->default(Season::SPRING->value); // e.g., spring, summer, autumn, winter
            $table->integer('year')->default(1);

            $table->unsignedInteger('width')->default(100);
            $table->unsignedInteger('height')->default(100);

            $table->integer('tick_count')->default(0);
            $table->longText('seed');

            $table->integer('temperature')->default(30);
            $table->integer('humidity')->default(50);

            $table->longText('back_story')->nullable();
            $table->longText('keywords');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worlds');
    }
};
