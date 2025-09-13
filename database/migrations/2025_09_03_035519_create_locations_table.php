<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_profile_id')->constrained()->onDelete('cascade');
            $table->text('street_address')->nullable();
            $table->string('city');
            $table->string('state_province')->nullable();
            $table->string('postal_code')->nullable();
            $table->char('country_code', 2); // ISO 3166-1 alpha-2
            $table->decimal('latitude', 10, 8)->nullable()->index(); // Precision for geolocation
            $table->decimal('longitude', 11, 8)->nullable()->index();

            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website_url')->nullable();
            $table->boolean('is_public')->default(true);
            $table->string('conact_form_email')->nullable();
            $table->timestamps();

            // Index for location-based searches
            $table->index(['latitude', 'longitude']);
            $table->index('country_code');
        });

        // Add spatial column using raw SQL - must be NOT NULL for spatial index
        DB::statement('ALTER TABLE locations ADD location POINT NOT NULL AFTER longitude');

        // Add spatial index using raw SQL
        DB::statement('ALTER TABLE locations ADD SPATIAL INDEX location_index (location)');
    }

    public function down()
    {
        Schema::dropIfExists('locations');
    }
};
