<x-guest-layout>
  {{-- แถวบน: Welcome + Sign up --}}
  <div class="flex items-start justify-between">
    <div>
      <p class="text-sm text-gray-500">
        Welcome to
        <span class="font-semibold text-blue-600">{{ config('app.name', 'COMP') }}</span>
      </p>
      <h1 class="mt-1 text-[44px] leading-none font-extrabold tracking-tight">Sign in</h1>
    </div>

    @if (Route::has('register'))
      <div class="text-right text-sm">
        <span class="text-gray-500">No Account ?</span><br>
        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:underline">Sign up</a>
      </div>
    @endif
  </div>

  {{-- สถานะ/ข้อผิดพลาด --}}
  @if (session('status'))
    <div class="mt-4 rounded-xl bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
  @endif
  @if ($errors->any())
    <div class="mt-3 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">
      <ul class="list-disc ml-5">
        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
      </ul>
    </div>
  @endif

  {{-- ฟอร์ม --}}
  <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-6">
    @csrf

    {{-- Email / Username --}}
    <div class="space-y-2">
      <label for="email" class="block text-sm font-medium text-gray-800">Enter your username or email address</label>
      <input id="email" name="email" type="text" value="{{ old('email') }}" required autofocus
             placeholder="Username or email address"
             class="block w-full rounded-2xl border border-blue-300 bg-white px-4 py-3
                    text-gray-900 placeholder-gray-400 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
    </div>

    {{-- Password --}}
    <div class="space-y-2">
      <label for="password" class="block text-sm font-medium text-gray-800">Enter your Password</label>
      <input id="password" name="password" type="password" required autocomplete="current-password"
             placeholder="Password"
             class="block w-full rounded-2xl border border-gray-300 bg-white px-4 py-3
                    text-gray-900 placeholder-gray-400 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
      {{-- Forgot Password ชิดขวาใต้ช่องรหัส --}}
      @if (Route::has('password.request'))
        <div class="text-right">
          <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Forgot Password</a>
        </div>
      @endif
    </div>

    {{-- Remember me --}}
    <div class="flex items-center gap-2 text-gray-600">
      <input id="remember_me" name="remember" type="checkbox"
             class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
      <label for="remember_me" class="text-sm">Remember me</label>
    </div>

    {{-- ปุ่ม --}}
    <button type="submit"
      class="w-full rounded-2xl bg-gradient-to-b from-blue-500 to-blue-600 px-4 py-3
             font-semibold text-white shadow-lg hover:from-blue-600 hover:to-blue-700
             active:translate-y-[1px] focus:outline-none focus:ring-2 focus:ring-blue-300">
      Sign in
    </button>
  </form>
</x-guest-layout>
