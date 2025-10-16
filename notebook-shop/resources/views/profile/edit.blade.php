@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<style>
    .profile-card {
        transition: all 0.3s ease;
    }
    
    .profile-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .avatar-container {
        position: relative;
        transition: all 0.3s ease;
    }

    .avatar-container:hover {
        transform: scale(1.05);
    }

    .input-field {
        transition: all 0.2s ease;
    }

    .input-field:focus {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
    }

    .fade-in {
        animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .delete-section {
        transition: all 0.3s ease;
    }

    .delete-section[open] {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            max-height: 0;
        }
        to {
            opacity: 1;
            max-height: 500px;
        }
    }
</style>

<div class="max-w-5xl mx-auto py-8">
    <!-- Header Section -->
    <div class="text-center mb-12 fade-in">
        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
            My Profile
        </h1>
        <p class="text-gray-600 text-lg">Manage your personal information and account security</p>
    </div>

    <!-- Success Message -->
    @if (session('status') === 'profile-updated')
        <div class="mb-8 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-6 shadow-sm fade-in">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-green-800">Saved Successfully!</h3>
                    <p class="text-green-700">Your profile information has been updated</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Profile Card -->
    <div class="bg-white rounded-3xl shadow-xl p-8 lg:p-12 mb-8 profile-card fade-in">
        <div class="grid lg:grid-cols-3 gap-8 lg:gap-12">
            <!-- Avatar Section -->
            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    <div class="text-center">
                        <div class="avatar-container inline-block mb-6">
                            <div class="relative">
                                <img 
                                    src="{{ $user->avatarUrl() }}" 
                                    alt="avatar" 
                                    class="w-48 h-48 rounded-full object-cover border-4 border-blue-100 shadow-lg"
                                >
                                <div class="absolute inset-0 bg-blue-600 rounded-full opacity-0 hover:opacity-10 transition-opacity"></div>
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $user->name }}</h2>
                        <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="lg:col-span-2">
                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('patch')

                    <!-- Upload Avatar -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border-2 border-blue-100">
                        <label class="flex items-center gap-3 mb-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-lg font-bold text-gray-900">Profile Picture</span>
                        </label>
                        <input 
                            type="file" 
                            name="avatar" 
                            accept="image/*"
                            class="w-full px-4 py-3 border-2 border-dashed border-blue-300 rounded-xl bg-white hover:border-blue-500 transition cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white file:font-medium file:cursor-pointer hover:file:bg-blue-700"
                        >
                        @error('avatar') 
                            <div class="flex items-center gap-2 mt-3 text-red-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Name Field -->
                    <div>
                        <label class="flex items-center gap-2 mb-3 text-gray-700 font-semibold">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Name
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name', $user->name) }}" 
                            class="input-field w-full px-5 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none bg-white"
                            placeholder="Enter your name"
                        >
                        @error('name') 
                            <div class="flex items-center gap-2 mt-2 text-red-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label class="flex items-center gap-2 mb-3 text-gray-700 font-semibold">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Email
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $user->email) }}" 
                            class="input-field w-full px-5 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none bg-white"
                            placeholder="example@email.com"
                        >
                        @error('email') 
                            <div class="flex items-center gap-2 mt-2 text-red-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Phone Field -->
                    <div>
                        <label class="flex items-center gap-2 mb-3 text-gray-700 font-semibold">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            Phone Number
                        </label>
                        <input 
                            type="text" 
                            name="phone" 
                            value="{{ old('phone', $user->phone) }}" 
                            class="input-field w-full px-5 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none bg-white"
                            placeholder="0xx-xxx-xxxx"
                        >
                        @error('phone') 
                            <div class="flex items-center gap-2 mt-2 text-red-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Address Field -->
                    <div>
                        <label class="flex items-center gap-2 mb-3 text-gray-700 font-semibold">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Address
                        </label>
                        <textarea 
                            name="address" 
                            rows="4" 
                            class="input-field w-full px-5 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none bg-white resize-none"
                            placeholder="Enter your delivery address"
                        >{{ old('address', $user->address) }}</textarea>
                        @error('address') 
                            <div class="flex items-center gap-2 mt-2 text-red-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-4 pt-6">
                        <button 
                            type="submit" 
                            class="flex-1 min-w-[200px] bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg shadow-blue-600/30 transition-all hover:shadow-xl hover:shadow-blue-600/40 hover:scale-105 flex items-center justify-center gap-2"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Changes
                        </button>
                        <a 
                            href="{{ url('/') }}" 
                            class="flex-1 min-w-[200px] bg-white hover:bg-gray-50 text-gray-700 px-8 py-4 rounded-xl font-bold text-lg border-2 border-gray-200 hover:border-gray-300 transition-all hover:scale-105 flex items-center justify-center gap-2"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Home
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Account Section -->
    <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-3xl shadow-lg p-8 border-2 border-red-100 fade-in">
        <details class="delete-section">
            <summary class="flex items-center gap-3 cursor-pointer select-none group">
                <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-red-800">Delete Account</h3>
                    <p class="text-sm text-red-600">This action cannot be undone</p>
                </div>
                <svg class="w-6 h-6 text-red-600 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </summary>
            
            <form method="post" action="{{ route('profile.destroy') }}" class="mt-8 bg-white rounded-2xl p-6 border-2 border-red-200">
                @csrf
                @method('delete')
                
                <div class="space-y-4">
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h4 class="font-bold text-red-800 mb-1">Warning!</h4>
                                <p class="text-sm text-red-700">Deleting your account will permanently remove all your data, including order history and personal information</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center gap-2 mb-2 text-gray-700 font-semibold">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Confirm Password
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            class="w-full px-5 py-3 border-2 border-red-200 rounded-xl focus:border-red-500 focus:outline-none bg-white"
                            placeholder="Enter your password to confirm"
                        >
                        @error('password') 
                            <div class="flex items-center gap-2 mt-2 text-red-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <button 
                        type="submit" 
                        onclick="return confirm('Are you sure you want to permanently delete your account? This action cannot be undone!')"
                        class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-4 rounded-xl font-bold text-lg shadow-lg shadow-red-600/30 transition-all hover:shadow-xl hover:shadow-red-600/40 hover:scale-105 flex items-center justify-center gap-2"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete Account Permanently
                    </button>
                </div>
            </form>
        </details>
    </div>
</div>
@endsection