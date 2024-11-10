<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
    <x-main full-width>

        <x-slot:content
            full-height
            class="w-full min-h-screen flex flex-col justify-center items-center"
        >
            <div class="w-full">
                <x-app-brand class="p-5 pt-3 place-self-center" />
                <div>
                    {{ $slot }}
                </div>
            </div>
        </x-slot:content>
    </x-main>
</body>

</html>
