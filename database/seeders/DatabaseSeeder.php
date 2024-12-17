<?php

namespace Database\Seeders;

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
            ProposalSeeder::class,
        ]);
    }
}
