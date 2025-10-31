{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'COMP') }}</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Noto+Sans+Thai:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Noto Sans Thai', sans-serif; }
    .font-anton { font-family: 'Anton', sans-serif; }
  </style>
</head>
<body class="antialiased text-gray-900">

  {{--  Navbar (เรียกจาก component ที่คุณสร้าง) --}}
  @include('components.navbar')

  {{--  เนื้อหาของแต่ละหน้า --}}
  <main>
    @yield('content')
  </main>


</body>
</html>
