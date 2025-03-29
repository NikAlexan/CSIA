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
        $this->call(class: array(
            UserSeeder::class,
            MicrogreenSeeder::class,
            BatchSeeder::class,
            ObservationSeeder::class,
            NotificationScheduleSeeder::class,
            SensorReadingCsvSeeder::class,
        ));


    }
}
