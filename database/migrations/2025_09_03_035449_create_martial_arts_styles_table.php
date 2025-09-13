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
        Schema::create('martial_arts_styles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Pivot table for provider_profiles <-> martial_arts_styles
        Schema::create('provider_profile_style', function (Blueprint $table) {
            $table->foreignId('provider_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('martial_arts_style_id')->constrained()->onDelete('cascade');
            $table->primary(['provider_profile_id', 'martial_arts_style_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('martial_arts_styles');
    }
};
