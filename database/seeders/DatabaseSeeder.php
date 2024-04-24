<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.com',
        ]);

        \App\Models\EventCalendar::factory(30)->create();
        \App\Models\Item::factory(249)->create();

        $this->callWith(GemSeeder::class);
        $this->callWith(JewelSeeder::class);
        $this->callWith(RuneSeeder::class);
    }
}
