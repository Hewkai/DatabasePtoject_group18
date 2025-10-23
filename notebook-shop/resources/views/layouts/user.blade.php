<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name', 'Notebook Shop'))</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- เพิ่มสไตล์เล็กน้อยสำหรับ dropdown hover --}}
    <style>
        .group:hover .group-hover\:opacity-100 {
            opacity: 1;
        }
        .group:hover .group-hover\:visible {
            visibility: visible;
        }
        .group:hover .group-hover\:rotate-180 {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        {{-- Navigation Bar สำหรับ User --}}
        @include('layouts.navigation')

        {{-- Page Content --}}
        <main class="flex-1">
            @yield('content')
        </main>
    </div>
</body>
</html>