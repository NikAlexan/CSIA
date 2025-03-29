<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\SensorReading;

class SensorReadingCsvSeeder extends Seeder
{
    public function run(): void
    {
        $path = base_path() . "/database/seeders/files/2025-03-20.csv";
        if (!file_exists($path)) {
            echo "CSV not found at: $path\n";
            return;
        }

        $file = fopen($path, 'r');
        $header = fgetcsv($file); // Чтение заголовков

        while (($row = fgetcsv($file)) !== false) {
            $data = array_combine($header, $row);

            SensorReading::create([
                'timestamp' => $data['timestamp'],
                'device' => $data['device'],
                'soil1' => $data['soil1'],
                'soil2' => $data['soil2'],
                'soil3' => $data['soil3'],
                'soil4' => $data['soil4'],
                'soil5' => $data['soil5'],
                'water_temperature' => $data['water_temperature'],
                'air_temperature' => $data['air_temperature'],
                'air_humidity' => $data['air_humidity'],
                'light_level' => $data['light_level'],
            ]);
        }

        fclose($file);
    }
}
