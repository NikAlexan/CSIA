<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Microgreen;

class MicrogreenSeeder extends Seeder
{
    public function run(): void
    {
        $microgreens = [
            [
                'name' => 'Базилик',
                'germination_time' => '5-7 дней',
                'temperature' => '20-24°C',
                'light' => 'Яркий рассеянный свет',
            ],
            [
                'name' => 'Редис',
                'germination_time' => '3-5 дней',
                'temperature' => '18-22°C',
                'light' => 'Хорошее освещение',
            ],
            [
                'name' => 'Горох',
                'germination_time' => '2-3 дня',
                'temperature' => '16-20°C',
                'light' => 'Светлый подоконник или лампа',
            ],
            [
                'name' => 'Подсолнух',
                'germination_time' => '2-3 дня',
                'temperature' => '20-22°C',
                'light' => 'Яркий свет',
            ],
            [
                'name' => 'Кресс-салат',
                'germination_time' => '2-4 дня',
                'temperature' => '18-20°C',
                'light' => 'Среднее освещение',
            ],
        ];

        foreach ($microgreens as $data) {
            Microgreen::create($data);
        }
    }
}

