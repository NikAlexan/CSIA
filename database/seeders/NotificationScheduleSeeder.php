<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NotificationSchedule;
use App\Models\User;

class NotificationScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            NotificationSchedule::create([
                'user_id' => $user->id,
                'type' => 'watering',
                'notify_at' => '08:00:00',
                'message' => 'Время полить микрозелень!',
            ]);

            NotificationSchedule::create([
                'user_id' => $user->id,
                'type' => 'daily_check',
                'notify_at' => '10:00:00',
                'message' => 'Оцените состояние микрозелени сегодня.',
            ]);

            NotificationSchedule::create([
                'user_id' => $user->id,
                'type' => 'tip',
                'notify_at' => null,
                'message' => 'Следите за влажностью — не более 60%, чтобы избежать плесени.',
                'enabled' => false,
            ]);
        }
    }
}
