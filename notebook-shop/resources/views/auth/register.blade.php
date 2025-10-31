<x-guest-layout>
    {{-- ไม่มีกรอบซ้อน: ไม่ใส่ bg-white / rounded / shadow ที่ชั้นใน --}}
    <div class="w-full max-w-md p-0">

        {{-- Header + Sign in มุมขวาบน --}}
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500">
                    Welcome to
                    <span class="font-semibold text-blue-600">{{ config('app.name', 'Notebook Shop') }}</span>
                </p>
                <h1 class="mt-1 text-[40px] leading-tight font-extrabold tracking-tight">
                    <span class="block">Sign up</span>
                </h1>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500">Have an Account ?</p>
                <a href="{{ route('login') }}"
                   class="text-sm font-medium text-blue-600 hover:underline">Sign in</a>
            </div>
        </div>

        {{-- ฟอร์มสมัคร --}}
        <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-6">
            @csrf

            {{-- Name --}}
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name"
                    class="block w-full rounded-2xl border border-gray-300 bg-white px-4 py-3
                           text-gray-900 placeholder-gray-400 shadow-sm
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    type="text" name="name" :value="old('name')" required autofocus
                    placeholder="Enter your Username" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email"
                    class="block w-full rounded-2xl border border-gray-300 bg-white px-4 py-3
                           text-gray-900 placeholder-gray-400 shadow-sm
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    type="email" name="email" :value="old('email')" required
                    placeholder="Enter your email address" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password"
                    class="block w-full rounded-2xl border border-gray-300 bg-white px-4 py-3
                           text-gray-900 placeholder-gray-400 shadow-sm
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    type="password" name="password" required autocomplete="new-password"
                    placeholder="Enter your Password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Confirm Password --}}
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation"
                    class="block w-full rounded-2xl border border-gray-300 bg-white px-4 py-3
                           text-gray-900 placeholder-gray-400 shadow-sm
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="Enter your Password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            {{-- ปุ่มฟ้าเต็มความกว้าง (เลี่ยง x-primary-button เพื่อไม่ให้สีเข้มเดิมทับ) --}}
            <button type="submit"
                class="w-full rounded-2xl bg-blue-600 px-4 py-3 font-semibold text-white
                       shadow-md hover:bg-blue-700 active:translate-y-[1px]
                       focus:outline-none focus:ring-2 focus:ring-blue-300">
                Sign up
            </button>
        </form>
    </div>
</x-guest-layout>
