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
        Schema::create('llm_responses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('noob_id')->constrained()->onDelete('cascade');
            $table->string('event_type');
            $table->json('event_details');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('llm_responses');
    }
};
