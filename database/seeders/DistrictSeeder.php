<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    public function run()
    {
        DB::table('districts')->insert([
            // Western Province
            ['province_id' => 1, 'name' => 'Colombo'],
            ['province_id' => 1, 'name' => 'Gampaha'],
            ['province_id' => 1, 'name' => 'Kalutara'],
            // Central Province
            ['province_id' => 2, 'name' => 'Kandy'],
            ['province_id' => 2, 'name' => 'Matale'],
            ['province_id' => 2, 'name' => 'Nuwara Eliya'],
            // Southern Province
            ['province_id' => 3, 'name' => 'Galle'],
            ['province_id' => 3, 'name' => 'Matara'],
            ['province_id' => 3, 'name' => 'Hambantota'],
            // Northern Province
            ['province_id' => 4, 'name' => 'Jaffna'],
            ['province_id' => 4, 'name' => 'Kilinochchi'],
            ['province_id' => 4, 'name' => 'Mannar'],
            ['province_id' => 4, 'name' => 'Vavuniya'],
            ['province_id' => 4, 'name' => 'Mullaitivu'],
            // Eastern Province
            ['province_id' => 5, 'name' => 'Batticaloa'],
            ['province_id' => 5, 'name' => 'Ampara'],
            ['province_id' => 5, 'name' => 'Trincomalee'],
            // North Western Province
            ['province_id' => 6, 'name' => 'Kurunegala'],
            ['province_id' => 6, 'name' => 'Puttalam'],
            // North Central Province
            ['province_id' => 7, 'name' => 'Anuradhapura'],
            ['province_id' => 7, 'name' => 'Polonnaruwa'],
            // Uva Province
            ['province_id' => 8, 'name' => 'Badulla'],
            ['province_id' => 8, 'name' => 'Monaragala'],
            // Sabaragamuwa Province
            ['province_id' => 9, 'name' => 'Ratnapura'],
            ['province_id' => 9, 'name' => 'Kegalle'],
        ]);
    }
}
