<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\ProviderProfile;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    public function run()
    {
        $profiles = ProviderProfile::all();

        foreach ($profiles as $profile) {
            // Create at least one location for each profile
            Location::create([
                'provider_profile_id' => $profile->id,
                'street_address' => '123 Main St',
                'city' => 'Sample City',
                'state_province' => 'CA',
                'postal_code' => '12345',
                'country_code' => 'US',
                'latitude' => 34.052235, // LA coordinates
                'longitude' => -118.243683,
                'phone' => '+1 (555) 123-4567',
            ]);

            // Randomly create a second location for some profiles
            if (rand(0, 1)) {
                Location::create([
                    'provider_profile_id' => $profile->id,
                    'street_address' => '456 Oak Ave',
                    'city' => 'Another Town',
                    'state_province' => 'NY',
                    'postal_code' => '67890',
                    'country_code' => 'US',
                    'latitude' => 40.712776, // NYC coordinates
                    'longitude' => -74.005974,
                    'phone' => '+1 (555) 987-6543',
                ]);
            }
        }
    }
}
