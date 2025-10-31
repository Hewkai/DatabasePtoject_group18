<x-guest-layout>
  {{-- Header + Sign in link (ขวาบน) --}}
  <div class="flex items-start justify-between">
    <div>
      <p class="text-sm text-gray-500">
        Welcome to <span class="font-semibold text-blue-600">{{ config('app.name', 'COMP') }}</span>
      </p>
      <h1 class="mt-1 text-[44px] leading-none font-extrabold tracking-tight">Sign up</h1>
    </div>

    @if (Route::has('login'))
      <div class="text-right text-sm">
        <span class="text-gray-500">Have an Account ?</span><br>
        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline">Sign in</a>
      </div>
    @endif
  </div>

  {{-- Errors --}}
  @if ($errors->any())
    <div class="mt-4 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700">
      <ul class="list-disc ml-5">
        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
      </ul>
    </div>
  @endif

  {{-- Form --}}
  <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-5">
    @csrf

    {{-- Name --}}
    <div class="space-y-2">
      <label for="name" class="block text-sm font-medium text-gray-800">Name</label>
      <input id="name" name="name" type="text" value="{{ old('name') }}" required
             placeholder="Enter your Username"
             class="block w-full rounded-2xl border border-blue-300 bg-white px-4 py-3
                    text-gray-900 placeholder-gray-400 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
    </div>

    {{-- Email --}}
    <div class="space-y-2">
      <label for="email" class="block text-sm font-medium text-gray-800">Email</label>
      <input id="email" name="email" type="email" value="{{ old('email') }}" required
             placeholder="Enter your email address"
             class="block w-full rounded-2xl border border-gray-300 bg-white px-4 py-3
                    text-gray-900 placeholder-gray-400 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
    </div>

    {{-- Password --}}
    <div class="space-y-2">
      <label for="password" class="block text-sm font-medium text-gray-800">Password</label>
      <input id="password" name="password" type="password" required
             placeholder="Enter your Password"
             class="block w-full rounded-2xl border border-gray-300 bg-white px-4 py-3
                    text-gray-900 placeholder-gray-400 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
    </div>

    {{-- Confirm Password --}}
    <div class="space-y-2">
      <label for="password_confirmation" class="block text-sm font-medium text-gray-800">Confirm Password</label>
      <input id="password_confirmation" name="password_confirmation" type="password" required
             placeholder="Enter your Password"
             class="block w-full rounded-2xl border border-gray-300 bg-white px-4 py-3
                    text-gray-900 placeholder-gray-400 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
    </div>

    {{-- Button --}}
    <button type="submit"
      class="w-full rounded-2xl bg-gradient-to-b from-blue-500 to-blue-600 px-4 py-3
             font-semibold text-white shadow-lg hover:from-blue-600 hover:to-blue-700
             active:translate-y-[1px] focus:outline-none focus:ring-2 focus:ring-blue-300">
      Sign up
    </button>
  </form>
</x-guest-layout>
