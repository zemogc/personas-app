<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-900">
        <div class="min-h-screen flex flex-col">
            <header class="max-w-7xl w-full mx-auto px-6 py-6 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2 font-semibold text-gray-800">
                    <x-application-logo class="h-8 w-8 fill-current text-indigo-600" />
                    {{ config('app.name') }}
                </a>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-4 text-sm">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">{{ __('Dashboard') }}</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">{{ __('Log in') }}</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-md bg-gray-800 px-4 py-2 font-semibold text-white hover:bg-gray-700">{{ __('Register') }}</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <main class="flex-1 flex items-center">
                <div class="max-w-7xl w-full mx-auto px-6 py-12 grid gap-12 lg:grid-cols-2 lg:items-center">
                    <div>
                        <h1 class="text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                            La división geográfica de un país, en un solo lugar.
                        </h1>
                        <p class="mt-6 text-lg text-gray-600">
                            Administra países, departamentos, municipios y comunas con búsqueda,
                            validación e integridad referencial. Los administradores gestionan
                            los catálogos; los lectores los consultan.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-3">
                            @auth
                                <a href="{{ route('dashboard') }}" class="rounded-md bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Ir al panel</a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-md bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">{{ __('Log in') }}</a>
                                <a href="{{ route('register') }}" class="rounded-md bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-gray-300 hover:bg-gray-50">Crear una cuenta</a>
                            @endauth
                        </div>
                    </div>

                    <ol class="space-y-3">
                        @foreach (['País' => 'Colombia', 'Departamento' => 'Valle del Cauca', 'Municipio' => 'Cali', 'Comuna' => 'Comuna 17'] as $nivel => $ejemplo)
                            <li class="flex items-center gap-4 rounded-lg bg-white p-4 shadow-sm" style="margin-left: {{ $loop->index * 1.5 }}rem">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-700">{{ $loop->iteration }}</span>
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-gray-500">{{ $nivel }}</p>
                                    <p class="font-medium text-gray-900">{{ $ejemplo }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </main>

            <footer class="py-6 text-center text-sm text-gray-500">
                Hecho con Laravel {{ Illuminate\Foundation\Application::VERSION }} · PHP {{ PHP_VERSION }}
            </footer>
        </div>
    </body>
</html>
