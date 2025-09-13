<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Mike Casto',
            'email' => 'castoware@gmail.com',
            'password' => Hash::make('password'),
            'type' => 'admin'
        ]);

        // Create 20 random users (mostly seekers)
        User::factory()->count(20)->create();

        // Create specific provider users
        $providers = [
            [
                'name' => 'Gracie Humaita',
                'email' => 'headcoach@graciehumaita.com',
                'password' => Hash::make('password'),
                'type' => 'provider',
            ],
            [
                'name' => 'Tiger Muay Thai',
                'email' => 'info@tigermuaythai.com',
                'password' => Hash::make('password'),
                'type' => 'provider',
            ],
            [
                'name' => 'NYC Judo Club',
                'email' => 'contact@nycjudo.com',
                'password' => Hash::make('password'),
                'type' => 'provider',
            ],
        ];

        foreach ($providers as $provider) {
            User::create($provider);
        }
    }
}
