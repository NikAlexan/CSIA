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
    <form action="{{ route('microgreen.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name">Название:</label>
            <input type="text" id="name" name="name" required class="border p-2 w-full" value="{{ old('name') }}">
        </div>

        <div>
            <label for="germination_time">Срок проращивания:</label>
            <input type="text" id="germination_time" name="germination_time" class="border p-2 w-full" value="{{ old('germination_time') }}">
        </div>

        <div>
            <label for="temperature">Температура:</label>
            <input type="text" id="temperature" name="temperature" class="border p-2 w-full" value="{{ old('temperature') }}">
        </div>

        <div>
            <label for="light">Освещение:</label>
            <input type="text" id="light" name="light" class="border p-2 w-full" value="{{ old('light') }}">
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2">Сохранить</button>
    </form>
    </body>
</html>
