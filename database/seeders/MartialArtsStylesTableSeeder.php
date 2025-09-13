<?php

namespace Database\Seeders;

use App\Models\MartialArtsStyle;
use Illuminate\Database\Seeder;

class MartialArtsStylesTableSeeder extends Seeder
{
    public function run()
    {
        $styles = [
            ['name' => 'Brazilian Jiu-Jitsu'],
            ['name' => 'Muay Thai'],
            ['name' => 'Judo'],
            ['name' => 'Karate'],
            ['name' => 'Taekwondo'],
            ['name' => 'Kung Fu'],
            ['name' => 'Boxing'],
            ['name' => 'Wrestling'],
            ['name' => 'Krav Maga'],
            ['name' => 'Aikido'],
        ];

        foreach ($styles as $style) {
            MartialArtsStyle::create($style);
        }
    }
}
