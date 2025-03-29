<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Observation;
use App\Models\Batch;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ObservationSeeder extends Seeder
{
    public function run(): void
    {
        $imageFiles = collect(range(1, 9))->map(function ($i) {
            return "observations/{$i}.jpg";
        })->filter(function ($path) {
            return Storage::exists($path);
        });
        #dd($imageFiles);

        $batches = Batch::all();

        if ($batches->isEmpty()) {
            $this->command->warn("Нет доступных batches для создания наблюдений.");
            return;
        }

        foreach ($batches as $batch) {
            $numObservations = rand(1, 3);
            for ($i = 0; $i < $numObservations; $i++) {
                Observation::create([
                    'batch_id' => $batch->id,
                    'date' => Carbon::now()->subDays(rand(0, 5)),
                    'visualChanges' => fake()->sentence(),
                    'image' => $imageFiles->random(),
                    'height' => rand(1, 10) . ' cm',
                    'notes' => fake()->paragraph(),
                ]);
            }
        }
    }
}
