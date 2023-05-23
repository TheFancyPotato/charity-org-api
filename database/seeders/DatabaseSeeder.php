<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SuperadminSeeder::class,
        ]);

        // development and testing environments seeders.
        if (!app()->isProduction()) {
            $this->call([
                FakeDataSeeder::class,
            ]);
        }
    }
}
