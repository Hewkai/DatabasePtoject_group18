<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in - LOREM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('/images/bgloginandsingin.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-color: #1e293b;
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

        .login-animate {
            animation: fadeInUp 0.6s ease-out;
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
<body class="min-h-screen flex items-center justify-center p-4">
    
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-[480px] p-12 login-animate">
        
        <!-- Top Section: Header & Sign Up -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <p class="text-sm text-gray-600 mb-1">
                    Welcome to <span class="text-sky-500 font-semibold">LOREM</span>
                </p>
                <h1 class="text-5xl font-semibold text-black">Sign in</h1>
            </div>
            
            <div class="text-right mt-2">
                <p class="text-[11px] text-gray-400 mb-0.5">No Account ?</p>
                <a href="{{ route('register') }}" class="text-xs text-sky-500 font-medium hover:underline">
                    Sign up
                </a>
            </div>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-5 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                {{ session('status') }}
            </div>
        @endif

        <!-- Social Login Buttons -->
        <div class="flex gap-3 mb-8">
            <button type="button" class="flex-[3] flex items-center justify-center gap-2 py-3.5 px-4 bg-slate-100 hover:bg-slate-200 rounded-xl text-slate-600 text-sm font-medium transition-all duration-300 hover:-translate-y-0.5">
                <svg width="20" height="20" viewBox="0 0 20 20">
                    <path fill="#4285F4" d="M19.6 10.23c0-.82-.1-1.42-.25-2.05H10v3.72h5.5c-.15.96-.74 2.31-2.04 3.22v2.45h3.16c1.89-1.73 2.98-4.3 2.98-7.34z"/>
                    <path fill="#34A853" d="M13.46 15.13c-.83.59-1.96 1-3.46 1-2.64 0-4.88-1.74-5.68-4.15H1.07v2.52C2.72 17.75 6.09 20 10 20c2.7 0 4.96-.89 6.62-2.42l-3.16-2.45z"/>
                    <path fill="#FBBC05" d="M3.99 10c0-.69.12-1.35.32-1.97V5.51H1.07A9.973 9.973 0 000 10c0 1.61.39 3.14 1.07 4.49l3.24-2.52c-.2-.62-.32-1.28-.32-1.97z"/>
                    <path fill="#EA4335" d="M10 3.88c1.88 0 3.13.81 3.85 1.48l2.84-2.76C14.96.99 12.7 0 10 0 6.09 0 2.72 2.25 1.07 5.51l3.24 2.52C5.12 5.62 7.36 3.88 10 3.88z"/>
                </svg>
                Sign in with Google
            </button>
            
            <button type="button" class="flex-1 flex items-center justify-center py-3.5 px-3 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all duration-300 hover:-translate-y-0.5">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="#1877F2">
                    <path d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z"/>
                </svg>
            </button>
            
            <button type="button" class="flex-1 flex items-center justify-center py-3.5 px-3 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all duration-300 hover:-translate-y-0.5">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="#000">
                    <path d="M17.444 12.75c-.21.644-.46 1.237-.75 1.779a9.456 9.456 0 01-1.03 1.531c-.447.513-.814.867-1.099 1.062-.443.304-.917.46-1.424.468-.364 0-.803-.104-1.314-.314-.512-.21-.983-.314-1.414-.314-.451 0-.935.104-1.452.314-.518.21-.936.32-1.255.33-.487.019-.971-.142-1.452-.483-.305-.215-.687-.584-1.146-1.107a11.428 11.428 0 01-1.572-2.36C1.04 12.037.667 10.514.667 9.046c0-1.626.352-3.029 1.056-4.208a6.203 6.203 0 012.176-2.224 5.778 5.778 0 012.879-.846c.565 0 1.306.175 2.226.52.918.346 1.507.52 1.765.52.193 0 .85-.204 1.966-.613 1.056-.389 1.947-.55 2.675-.486 1.977.16 3.462.942 4.45 2.35-1.77 1.073-2.645 2.574-2.626 4.503.018 1.503.561 2.755 1.629 3.754a5.44 5.44 0 001.525.999 20.09 20.09 0 01-.387 1.095zM13.852 1.021c0 1.178-.43 2.278-1.29 3.297-.104.123-.22.237-.347.342A4.813 4.813 0 019.42 5.75a4.665 4.665 0 01-.078-.791c0-1.13.491-2.34 1.364-3.328.436-.499.99-.914 1.66-1.246.669-.327 1.302-.506 1.897-.53.019.283.029.567.029.851v.315z"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('login') }}">
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
                    autofocus 
                    autocomplete="username"
                >
                @if ($errors->get('email'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <!-- Password -->
            <div class="mb-3">
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
                    autocomplete="current-password"
                >
                @if ($errors->get('password'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <!-- Forgot Password -->
            <div class="text-right mb-6">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-sky-500 font-medium hover:underline">
                        Forgot Password
                    </a>
                @endif
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-6">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    name="remember"
                    class="w-[18px] h-[18px] rounded border-gray-300 text-sky-500 focus:ring-sky-500 cursor-pointer accent-sky-500"
                >
                <label for="remember_me" class="ml-2 text-sm text-slate-600 cursor-pointer">
                    Remember me
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 bg-sky-500 hover:bg-sky-600 text-white font-semibold rounded-xl text-base transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-sky-500/40">
                Sign in
            </button>
        </form>
        
    </div>

</body>
</html>