<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    public function run()
    {
        DB::table('provinces')->insert([
            // Sri Lanka Provinces
            ['country_id' => 1, 'name' => 'Western'],
            ['country_id' => 1, 'name' => 'Central'],
            ['country_id' => 1, 'name' => 'Southern'],
            ['country_id' => 1, 'name' => 'Northern'],
            ['country_id' => 1, 'name' => 'Eastern'],
            ['country_id' => 1, 'name' => 'North Western'],
            ['country_id' => 1, 'name' => 'North Central'],
            ['country_id' => 1, 'name' => 'Uva'],
            ['country_id' => 1, 'name' => 'Sabaragamuwa'],
        ]);
    }
}
