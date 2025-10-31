<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'COMP') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    {{-- พื้นหลังภาพ  --}}
    <div
        class="min-h-screen w-full bg-cover bg-center bg-no-repeat relative"
        style="background-image: url('{{ asset('pic/blueback.png') }}');"
    >
        <div class="absolute inset-0 bg-black/20"></div>

        {{-- กล่องฟอร์มกลางจอ --}}
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-8">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
