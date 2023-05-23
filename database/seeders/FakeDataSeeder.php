<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Family;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(20)->create();
        City::factory(30)->create();
        Family::factory(300)->create();
        Invoice::factory(500)->create();
    }
}
