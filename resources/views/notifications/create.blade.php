<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        @laravelPWA
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @routes
        @vite(['resources/js/app.ts'])
    </head>
    <body class="font-sans antialiased">
        <form method="POST" action="{{ route('notifications.schedule.store') }}">
    @csrf

    <label for="user_id">Пользователь:</label>
    <select name="user_id" required>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>

    <label for="type">Тип уведомления:</label>
    <select name="type" required>
        <option value="{{\App\NotificationTypes::Watering}}">Полив</option>
        <option value="{{\App\NotificationTypes::DailyCheck}}">Ежедневная проверка</option>
        <option value="{{\App\NotificationTypes::Tip}}">Подсказка</option>
    </select>

    <label for="notify_at">Время уведомления (HH:MM:SS):</label>
    <input type="time" name="notify_at">

    <label for="message">Сообщение:</label>
    <input type="text" name="message" class="bg-[#1b1b18]">

    <label for="enabled">Активно:</label>
    <input type="checkbox" name="enabled" value="1" checked>

    <button type="submit">Сохранить</button>
</form>

    </body>
</html>
