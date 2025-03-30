<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Microgreen;

class MicrogreenSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Базилик',
                'germination_min_days' => 5,
                'germination_max_days' => 7,
                'temperature_min' => 20,
                'temperature_max' => 24,
                'light' => 'Яркий рассеянный свет',
            ],
            [
                'name' => 'Редис',
                'germination_min_days' => 3,
                'germination_max_days' => 5,
                'temperature_min' => 18,
                'temperature_max' => 22,
                'light' => 'Хорошее освещение',
            ],
            [
                'name' => 'Горох',
                'germination_min_days' => 2,
                'germination_max_days' => 3,
                'temperature_min' => 16,
                'temperature_max' => 20,
                'light' => 'Светлый подоконник или лампа',
            ],
        ];

        foreach ($data as $item) {
            Microgreen::create($item);
        }
    }
}
