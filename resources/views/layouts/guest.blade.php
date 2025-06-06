<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Veterinaria Huellitas') }}</title>

    {{-- Fuente y Vite --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- SEO básico --}}
    <meta name="description" content="Veterinaria Huellitas - cuidado y salud para tus mascotas con amor y tecnología.">
    <meta name="theme-color" content="#6b21a8">
</head>

<body class="antialiased font-sans bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100">
    <div class="min-h-screen flex flex-col justify-center items-center">
        {{ $slot }}
    </div>
</body>
</html>




