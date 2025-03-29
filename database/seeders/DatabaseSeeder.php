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
        $this->call([
            UserSeeder::class,
            MicrogreenSeeder::class,
            BatchSeeder::class,
            ObservationSeeder::class,
        ]);

        $this->call([
            MicrogreenSeeder::class,
        ]);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    }
}
