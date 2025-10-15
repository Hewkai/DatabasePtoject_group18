<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up - LOREM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            background-image: url('/images/bgloginandsingin.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 0;
        }

        body::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background-color: #f8f9fa;
            z-index: 0;
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-animate {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .image-animate {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes inputFocus {
            from {
                transform: scale(0.98);
            }
            to {
                transform: scale(1);
            }
        }

        input:focus {
            animation: inputFocus 0.3s ease;
        }
    </style>
</head>
<body class="min-h-screen">
    
    <div class="content-wrapper min-h-screen flex items-center justify-center p-4">
        
        <!-- Form Container (Center) -->
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-[480px] p-12 register-animate">
            
            <!-- Top Section: Header & Sign In Link -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <p class="text-sm text-gray-600 mb-1">
                        Welcome to Lorem
                    </p>
                    <h1 class="text-5xl font-semibold text-black">Sign up</h1>
                </div>
                
                <div class="text-right mt-2">
                    <p class="text-[11px] text-gray-400 mb-0.5">Have an Account ?</p>
                    <a href="{{ route('login') }}" class="text-xs text-sky-500 font-medium hover:underline">
                        Sign in
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-900 mb-2">
                        Enter your username or email address
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="Username or email address"
                        class="w-full px-4 py-3.5 bg-white border border-slate-300 rounded-xl text-sm placeholder:text-slate-400 focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition-all duration-300"
                        required 
                        autocomplete="username"
                    >
                    @if ($errors->get('email'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <!-- User name & Contact Number (2 columns) -->
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <!-- User name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-900 mb-2">
                            User name
                        </label>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            placeholder="User name"
                            class="w-full px-4 py-3.5 bg-white border border-slate-300 rounded-xl text-sm placeholder:text-slate-400 focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition-all duration-300"
                            required 
                            autofocus 
                            autocomplete="name"
                        >
                        @if ($errors->get('name'))
                            <p class="text-red-500 text-xs mt-1">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <label for="contact_number" class="block text-sm font-medium text-gray-900 mb-2">
                            Contact Number
                        </label>
                        <input 
                            id="contact_number" 
                            type="text" 
                            name="contact_number" 
                            value="{{ old('contact_number') }}" 
                            placeholder="Contact Number"
                            class="w-full px-4 py-3.5 bg-white border border-slate-300 rounded-xl text-sm placeholder:text-slate-400 focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition-all duration-300"
                            autocomplete="tel"
                        >
                        @if ($errors->get('contact_number'))
                            <p class="text-red-500 text-xs mt-1">{{ $errors->first('contact_number') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-900 mb-2">
                        Enter your Password
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        placeholder="Password"
                        class="w-full px-4 py-3.5 bg-white border border-slate-300 rounded-xl text-sm placeholder:text-slate-400 focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition-all duration-300"
                        required 
                        autocomplete="new-password"
                    >
                    @if ($errors->get('password'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <!-- Confirm Password (Hidden - Laravel still validates it) -->
                <input 
                    id="password_confirmation" 
                    type="hidden" 
                    name="password_confirmation" 
                    value=""
                >

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3.5 bg-sky-500 hover:bg-sky-600 text-white font-semibold rounded-xl text-base transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-sky-500/40">
                    Sign up
                </button>
            </form>
            
        </div>

    </div>

    <!-- Decorative Image (Right Side Only) -->
    <div class="hidden lg:block fixed right-0 top-1/2 -translate-y-1/2 w-1/2 flex items-center justify-center pointer-events-none z-10">
        <img src="/images/loginadd.png" alt="Decorative illustration" class="w-full max-w-[450px] h-auto object-contain image-animate mx-auto">
    </div>

    <script>
        // Auto-fill password confirmation with password value
        document.getElementById('password').addEventListener('input', function() {
            document.getElementById('password_confirmation').value = this.value;
        });
    </script>

</body>
</html>