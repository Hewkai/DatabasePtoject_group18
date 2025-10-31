<x-guest-layout>
    <div class="space-y-7">
        {{-- Header (ซ้าย: Welcome/Sign in , ขวา: Sign up) --}}
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500">
                    Welcome to
                    <span class="font-semibold text-blue-600">{{ config('app.name', 'COMP') }}</span>
                </p>
                <h1 class="mt-1 text-[40px] leading-tight font-extrabold tracking-tight">
                    <span class="block">Sign in</span>
                </h1>
            </div>

            @if (Route::has('register'))
                <div class="text-right">
                    <p class="text-xs text-gray-500">Don’t have an account?</p>
                    <a href="{{ route('register') }}"
                       class="text-sm font-medium text-blue-600 hover:underline">
                        Sign up
                    </a>
                </div>
            @endif
        </div>

    


        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            {{-- Username / Email --}}
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-gray-800">
                    Enter your username or email address
                </label>
                <input
                    id="email" name="email" type="text" value="{{ old('email') }}" required autofocus
                    placeholder="Username or email address"
                    class="block w-full rounded-2xl border border-gray-300 bg-white px-4 py-3
                           text-gray-900 placeholder-gray-400 shadow-sm
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                >
            </div>

            {{-- Password --}}
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-gray-800">
                    Enter your Password
                </label>
                <input
                    id="password" name="password" type="password" required autocomplete="current-password"
                    placeholder="Password"
                    class="block w-full rounded-2xl border border-gray-300 bg-white px-4 py-3
                           text-gray-900 placeholder-gray-400 shadow-sm
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                >
            </div>

            {{-- Remember me + Forgot Password --}}
            <div class="flex items-center justify-between text-gray-600">
                <div class="flex items-center gap-2">
                    <input id="remember_me" name="remember" type="checkbox"
                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="remember_me" class="text-sm">Remember me</label>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-blue-600 hover:underline">
                        Forgot Password
                    </a>
                @endif
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full rounded-2xl bg-blue-600 px-4 py-3 font-semibold text-white
                       shadow-md hover:bg-blue-700 active:translate-y-[1px]
                       focus:outline-none focus:ring-2 focus:ring-blue-300">
                Log in
            </button>
        </form>
    </div>
</x-guest-layout>
