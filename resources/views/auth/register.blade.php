<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - Progrest</title>

    <link rel="icon" href="images/progrest_p_logo_green.png">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Parkinsans:wght@600;700&family=Redacted+Script:wght@400;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js']) 

    <style>
        .font-inter { font-family: 'Inter', sans-serif; }
        .font-parkinsans { font-family: 'Parkinsans', sans-serif; }
        .font-redacted { font-family: 'Redacted Script', cursive; }

        @keyframes fastReveal {
            from { 
                opacity: 0; 
                transform: translateY(15px) scale(0.99); 
            }

            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }

        .animate-reveal {
            animation: fastReveal 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
    </style>
</head>

<body class="font-inter antialiased h-screen w-screen bg-cover bg-center bg-no-repeat flex items-center justify-center p-4 md:p-8 overflow-hidden" 
    style="background-image: url('images/Checker_BG.png'); background-color: #E9F2EE;">

    <div class="w-full max-w-85 md:max-w-2xl lg:max-w-6xl h-auto lg:h-[85vh] lg:max-h-212.5 min-h-min lg:min-h-[600px] bg-white/90 backdrop-blur-md rounded-[30px] lg:rounded-[40px] shadow-2xl flex flex-col lg:flex-row relative animate-reveal">
        
        {{-- LOGO --}}
        <div class="absolute top-6 right-8 hidden lg:block z-50">
            <img 
                src="images/progrest_logo_green.png" 
                alt="Progrest" 
                class="h-8 w-auto hover:scale-105 transition duration-300 cursor-pointer"
            >
        </div>

        {{-- LEFT --}}
        <div class="w-full lg:w-13/16 p-6 lg:px-12 flex flex-col justify-center relative z-10 h-full animate-reveal delay-100 opacity-0">
            
            <div class="w-full mx-auto">
                {{--TOMBOL BACK--}}
                <div class="absolute left-6 md:left-12">
                        <a href="/" class="w-9 h-9 md:w-10 md:h-10 bg-primary hover:bg-[#217750] text-white rounded-full flex items-center justify-center transition-colors shadow-sm cursor-pointer">
                            <x-lucide-corner-up-left class="w-4 h-4 md:w-5 md:h-5 stroke-[2.5px]" />
                        </a>
                </div>

                {{-- TITLE --}}
                <div class="relative w-max mx-auto mb-3 mt-0">

                    <h1 class="text-5xl md:text-[3.5rem] text-center font-bold text-[#217750] font-parkinsans tracking-wide leading-none">
                        Register
                    </h1>

                    <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-[62%] w-[115%] text-[4rem] md:text-[4.5rem] text-primary font-redacted opacity-90 pointer-events-none leading-none text-center">
                        Register
                    </span>

                </div>

                {{-- DESC --}}
                <p class="text-[#545454] text-center text-sm mb-6 leading-relaxed">
                    By creating a Progrest account, you can enhance your project planning management collaboratively with your peers.
                </p>

                {{-- FORM --}}
                <form id="registerForm" action="/register" method="POST" class="space-y-3.5 grid grid-cols-2 gap-3">
                    @csrf
                    {{-- USERNAME --}}
                    <div>

                        <label class="block text-sm font-bold text-text-primary mb-1">
                            Username
                        </label>

                        <div class="relative">
                            
                            <input 
                                id="usernameInput" required
                                type="text" name="username" 
                                value="{{ old("username") }}"
                                placeholder="Must be 4-8 characters & unique" 
                                class="w-full border-2 border-gray-200 rounded-lg pl-4 pr-12 py-2.5  md:py-2 focus:outline-none focus:border-primary focus:bg-gray-50 text-sm transition-all text-text-primary placeholder-gray-400"
                            >
                            <div class="absolute right-4 top-1/2 -translate-y-1/2">
                                <x-lucide-user class="w-5 h-5 text-primary" />
                            </div>
                        </div>
                        @error('username')
                            <div class="text-red-500 text-sm mt-px">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- FULL NAME --}}
                    <div>

                        <label class="block text-sm font-bold text-text-primary mb-1">
                            Full Name
                        </label>

                        <div class="relative">
                        
                            <input 
                                id="nameInput" required
                                type="text" name="name"
                                value="{{ old("name") }}"
                                placeholder="Must be 6-12 characters" 
                                class="w-full border-2 border-gray-200 rounded-lg pl-4 pr-12 py-2.5  md:py-2 focus:outline-none focus:border-primary focus:bg-gray-50 text-sm transition-all text-text-primary placeholder-gray-400"
                            >
                            <div class="absolute right-4 top-1/2 -translate-y-1/2">
                                <x-lucide-user-round class="w-5 h-5 text-primary" />
                            </div>
                            
                        </div>
                        @error('name')
                            <div class="text-red-500 text-sm mt-px">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div>

                        <label class="block text-sm font-bold text-text-primary mb-1">
                            E-mail Address
                        </label>

                        <div class="relative">

                            <input 
                                id="emailInput" required
                                type="text" name="email"
                                value="{{ old("email") }}"
                                placeholder="Must be appropriate & unique" 
                                class="w-full border-2 border-gray-200 rounded-lg pl-4 pr-12 py-2.5  md:py-2 focus:outline-none focus:border-primary focus:bg-gray-50 text-sm transition-all text-text-primary placeholder-gray-400"
                            >
                            <div class="absolute right-4 top-1/2 -translate-y-1/2">
                                <x-lucide-mail class="w-5 h-5 text-primary" />
                            </div>

                        </div>

                        @error('email')
                            <div class="text-red-500 text-sm mt-px">{{ $message }}</div>
                        @enderror 

                    </div>

                    {{-- PASSWORD --}}
                    <div>

                        <label class="block text-sm font-bold text-text-primary mb-1">
                            Password
                        </label>

                        <div class="relative">

                            <input 
                                id="passwordInput" required
                                type="password" name="password"
                                value="{{ old("password") }}"
                                placeholder="Must be 6-12 alphanumeric chars" 
                                class="w-full border-2 border-gray-200 rounded-lg pl-4 pr-12 py-2.5  md:py-2 focus:outline-none focus:border-primary focus:bg-gray-50 text-sm transition-all text-text-primary placeholder-gray-400"
                            >

                            <div class="absolute right-4 top-1/2 -translate-y-1/2">
                                <x-lucide-lock class="w-5 h-5 text-primary" />
                            </div>

                            @error('password')
                                <div class="text-red-500 text-sm mt-px">{{ $message }}</div>
                            @enderror

                        </div>

                    </div>

                    {{-- BOTTOM SECTION --}}
                    <div class="flex flex-col w-full h-full col-span-2">

                        {{-- LOGIN REDIRECT --}}
                        <div class="text-center text-sm text-[#545454] mt-3 mb-2">
                            Already have an account?

                            <a href="/login" class="font-bold text-text-secondary hover:text-primary transition-colors underline decoration-1 underline-offset-4">
                                Sign In
                            </a>
                        </div>

                        {{-- REGISTER BUTTON --}}
                        <button 
                            type="submit" 
                            class="w-[80%] mx-auto block bg-primary hover:bg-[#217750] text-white font-bold py-2.5  md:py-2 rounded-xl transition-all shadow-md active:scale-95"
                        >
                            Register
                        </button>

                        {{-- OR --}}
                        <div class="flex items-center justify-center gap-3 my-2 opacity-70">

                            <hr class="w-43.75 border-gray-300">

                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider whitespace-nowrap">
                                OR
                            </span>

                            <hr class="w-43.75 border-gray-300">

                        </div>

                        {{-- GOOGLE --}}
                        <a href="/google" class="w-[80%] mx-auto flex bg-white border-2 border-primary text-text-primary font-bold py-1.5 rounded-xl flex items-center justify-center gap-3 hover:bg-gray-50 transition-all shadow-sm active:scale-95">

                            <img 
                                src="images/Google_Icon.png" 
                                alt="" 
                                class="w-4"
                            > 

                            Continue with Google

                        </a>

                    </div>

                </form>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="hidden lg:block w-1/2 relative h-full animate-reveal delay-200 opacity-0">

            {{-- SINGLE PORTRAIT IMAGE --}}
            <div class="absolute top-1/2 left-1/2 
                        -translate-x-1/2 -translate-y-1/2
                        w-[75%] h-[75%]
                        rounded-[30px]
                        overflow-hidden
                        shadow-2xl
                        border-4 border-white
                        bg-[#E9F2EE]
                        transform transition-all duration-500
                        hover:scale-105 hover:rotate-2">

                <img 
                    src="images/corporate.jpg"
                    alt="Corporate Strategy Workshop with Colorful Ideas Wall"
                    class="w-full h-full object-cover"
                >

            </div>

        </div>

    </div>
</body>
</html>