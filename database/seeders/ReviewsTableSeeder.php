<?php

namespace Database\Seeders;

use App\Models\ProviderProfile;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    public function run()
    {
        // Get all seekers
        $seekers = User::where('type', 'seek')->get();
        $providers = ProviderProfile::all();

        foreach ($providers as $provider) {
            // Create 3-5 reviews for each provider
            for ($i = 0; $i < rand(3, 5); $i++) {
                // Pick a random seeker to author the review
                $seeker = $seekers->random();

                Review::create([
                    'user_id' => $seeker->id,
                    'provider_profile_id' => $provider->id,
                    'rating' => rand(4, 5), // Mostly positive reviews for seed
                    'title' => 'Amazing Experience!',
                    'content' => 'This place is fantastic. The instructors are knowledgeable and the community is welcoming.',
                    'is_verified' => (bool) rand(0, 1), // Randomly verify some
                ]);
            }
        }
    }
}
