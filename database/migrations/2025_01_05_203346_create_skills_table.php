<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('noob_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., strength, perception
            $table->unsignedInteger('level')->default(1);
            $table->unsignedInteger('experience')->default(0);

            $table->timestamps();

            $table->unique(['noob_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
