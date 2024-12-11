<?php

namespace Database\Seeders;

use Database\Seeders\CountrySeeder;
use Database\Seeders\ProvinceSeeder;
use Database\Seeders\DistrictSeeder;
use Database\Seeders\ProposalSeeder;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the seeders
        $this->call([
            CountrySeeder::class,
            ProvinceSeeder::class,
            DistrictSeeder::class,
            ProposalSeeder::class,
        ]);
    }
}
