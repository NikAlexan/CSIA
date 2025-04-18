<?php

namespace App;

enum NotificationTypes: string
{
    // типы уведомлений
    case Watering = 'watering';
    case DailyCheck = 'daily_check';
    case Tip = 'tip';

    // Добавить название для case в формате self:case
    public function getName(): string
    {
        return match ($this) {
            self::Watering => 'Полив',
            self::DailyCheck => 'Ежедневная проверка',
            self::Tip => 'Подсказка',
            default => 'Undefined name'
        };
    }

    public static function array(): array
    {
        return array_map(function($case) {
            return [
                'value' => $case->value,
                'name' => $case->getName()
            ];
        }, self::cases());
    }
}
