<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\NotificationSchedule;
use App\NotificationTypes;

class NotificationScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            NotificationSchedule::create([
                'user_id' => $user->id,
                'type' => NotificationTypes::Watering->value,
                'notify_at' => '08:00:00',
                'message' => NotificationTypes::Watering->getName() . ' — Время полить микрозелень!',
            ]);

            NotificationSchedule::create([
                'user_id' => $user->id,
                'type' => NotificationTypes::DailyCheck->value,
                'notify_at' => '10:00:00',
                'message' => NotificationTypes::DailyCheck->getName() . ' — Оцените состояние микрозелени сегодня.',
            ]);

            NotificationSchedule::create([
                'user_id' => $user->id,
                'type' => NotificationTypes::Tip->value,
                'notify_at' => null,
                'message' => NotificationTypes::Tip->getName() . ' — Следите за влажностью — не более 60%.',
                'enabled' => false,
            ]);
        }
    }
}
