<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Notebook Shop') }}</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">

  {{-- พื้นหลังภาพแบบเต็มจอ + overlay ฟ้าโปร่ง --}}
  <div
    class="min-h-screen w-full bg-cover bg-center bg-no-repeat relative"
    style="background-image: url('{{ asset('images/blueback.png') }}');"
  >
    <div class="absolute inset-0 bg-black/10"></div>

    {{-- กล่องฟอร์มกลางจอ --}}
    <div class="relative min-h-screen flex items-center justify-center px-6">
      <div class="w-full max-w-lg bg-white/95 backdrop-blur-lg rounded-[32px] shadow-2xl p-10">
        {{ $slot }}
      </div>
    </div>
  </div>

</body>
</html>
