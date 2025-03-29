<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Batch;
use App\Models\User;
use App\Models\Microgreen;
use Carbon\Carbon;

class BatchSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $microgreens = Microgreen::all();

        foreach ($users as $user) {
            foreach ($microgreens->random(2) as $microgreen) {
                $sowingDate = Carbon::now()->subDays(rand(10, 20));
                $collectionOffset = Carbon::now()->subDays(rand(1, 10));

                Batch::create([
                    'user_id' => $user->id,
                    'microgreen_id' => $microgreen->id,
                    'dateOfSowing' => $sowingDate,
                    'dateOfCollection' => $collectionOffset,
                ]);
            }
        }
    }
}
