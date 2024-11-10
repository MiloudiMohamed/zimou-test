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

    <x-nav sticky full-width>
        <x-slot:brand>
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>

            <x-app-brand />
        </x-slot:brand>

        @auth
            <x-slot:actions>
                <x-dropdown label="{{ auth()->user()->name }}" right>
                    <x-form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">
                            <x-menu-item
                                title="Logout"
                                icon="o-arrow-right-on-rectangle"
                                class="min-w-48"
                            />
                        </button>
                    </x-form>
                </x-dropdown>
            </x-slot:actions>
        @endauth
    </x-nav>

    <x-main full-width>
        <x-slot:sidebar
            drawer="main-drawer"
            collapsible
            class="bg-base-100 lg:bg-inherit"
        >
            <x-menu activate-by-route>
                <x-menu-item
                    title="Packages"
                    icon="o-cube"
                    link="/"
                />
            </x-menu>
        </x-slot:sidebar>

        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    <x-toast />
</body>

</html>
