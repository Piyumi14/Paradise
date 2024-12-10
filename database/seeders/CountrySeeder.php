<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run()
    {
        DB::table('countries')->insert([
            ['id' => 1, 'name' => 'Sri Lanka'],
            ['id' => 2, 'name' => 'Australia'],
            ['id' => 3, 'name' => 'United States'],
            ['id' => 4, 'name' => 'United Kingdom'],
            ['id' => 5, 'name' => 'Canada'],
            ['id' => 6, 'name' => 'Dubai'],
            ['id' => 7, 'name' => 'France'],
            ['id' => 8, 'name' => 'Friendland'],
            ['id' => 9, 'name' => 'India'],
            ['id' => 10, 'name' => 'Other'],
        ]);
    }
}
