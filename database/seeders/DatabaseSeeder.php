<?php

namespace Database\Seeders;

use App\Data\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call(TrainsUserSeeder::class);
        $this->call(SocialAccountsSeed::class);
    }
}
