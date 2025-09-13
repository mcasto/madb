<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            MartialArtsStylesTableSeeder::class,
            UsersTableSeeder::class,
            ProviderProfilesTableSeeder::class,
            LocationsTableSeeder::class,
            ReviewsTableSeeder::class,
        ]);
    }
}
