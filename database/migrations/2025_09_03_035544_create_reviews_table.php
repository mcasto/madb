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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('provider_profile_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating'); // e.g., 1-5
            $table->string('title');
            $table->text('content');
            $table->boolean('is_verified')->default(false);
            $table->timestamps();

            // A user can only leave one review per provider
            $table->index(['user_id', 'provider_profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
