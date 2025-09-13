<?php

namespace Database\Seeders;

use App\Models\MartialArtsStyle;
use App\Models\ProviderProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProviderProfilesTableSeeder extends Seeder
{
    public function run()
    {
        // Get all users who are providers
        $providerUsers = User::where('type', 'provider')->get();
        // Get all styles for attaching
        $styles = MartialArtsStyle::all();

        $profiles = [
            [
                'user_id' => $providerUsers->where('email', 'headcoach@graciehumaita.com')->first()->id,
                'business_name' => 'Gracie Humaita',
                'description' => 'A world-renowned Brazilian Jiu-Jitsu academy founded by the Gracie family.',
                'year_established' => 1995,
                'subscription_tier' => 'premium',
                'subscription_status' => 'active',
            ],
            [
                'user_id' => $providerUsers->where('email', 'info@tigermuaythai.com')->first()->id,
                'business_name' => 'Tiger Muay Thai',
                'description' => 'A premier Muay Thai and MMA training camp in Phuket, Thailand.',
                'year_established' => 2003,
                'subscription_tier' => 'premium',
                'subscription_status' => 'active',
            ],
            [
                'user_id' => $providerUsers->where('email', 'contact@nycjudo.com')->first()->id,
                'business_name' => 'NYC Judo Club',
                'description' => 'Dedicated to promoting the art and sport of Judo in New York City.',
                'year_established' => 1980,
                'subscription_tier' => 'free', // Example of a free tier profile
                'subscription_status' => 'active',
            ],
        ];

        foreach ($profiles as $profileData) {
            // Create the profile
            $profile = ProviderProfile::create($profileData);

            // Attach random styles to the profile (1-3 styles each)
            $randomStyles = $styles->random(rand(1, 3))->pluck('id');
            $profile->styles()->attach($randomStyles);
        }
    }
}
