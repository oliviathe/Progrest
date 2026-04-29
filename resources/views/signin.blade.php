<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign In - Progrest</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Parkinsans:wght@600;700&family=Redacted+Script:wght@400;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js']) 

    <style>
        .font-inter { font-family: 'Inter', sans-serif; }
        .font-parkinsans { font-family: 'Parkinsans', sans-serif; }
        .font-redacted { font-family: 'Redacted Script', cursive; }

        @keyframes fastReveal {
            from { opacity: 0; transform: translateY(15px) scale(0.99); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .animate-reveal {
            animation: fastReveal 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
    </style>
</head>
<body class="font-inter antialiased min-h-screen lg:h-screen w-full bg-cover bg-center bg-no-repeat flex items-center justify-center p-4 py-8 md:p-8 overflow-x-hidden lg:overflow-hidden" 
      style="background-image: url('images/Checker_BG.png'); background-color: #E9F2EE;">

    <div class="w-full max-w-[340px] md:max-w-2xl lg:max-w-6xl h-auto lg:h-[85vh] lg:max-h-[850px] min-h-min lg:min-h-[600px] bg-white/90 backdrop-blur-md rounded-[30px] lg:rounded-[40px] shadow-2xl flex flex-col lg:flex-row relative animate-reveal">
        
        <div class="absolute top-6 right-8 hidden lg:block z-50">
            <img src="images/progrest_logo_green.png" alt="Progrest" class="h-8 w-auto hover:scale-105 transition duration-300 cursor-pointer">
        </div>

        <div class="w-full lg:w-1/2 p-5 lg:px-12 flex flex-col justify-center relative z-10 h-full animate-reveal delay-100 opacity-0">
            
            <div class="w-full max-w-md mx-auto">
                
                <div class="relative w-full flex items-center justify-center mb-3 mt-0">
                    
                    <div class="absolute left-0">
                        <a href="javascript:history.back()" class="w-9 h-9 md:w-10 md:h-10 bg-[#14452F] hover:bg-[#217750] text-white rounded-full flex items-center justify-center transition-colors shadow-sm cursor-pointer">
                            <x-lucide-corner-up-left class="w-4 h-4 md:w-5 md:h-5 stroke-[2.5px]" />
                        </a>
                    </div>

                    <div class="relative w-max">
                        <h1 class="text-4xl md:text-[3.5rem] text-center font-bold text-[#217750] font-parkinsans tracking-wide leading-none">Sign In</h1>
                        <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-[62%] w-[115%] text-5xl md:text-[4.5rem] text-[#14452F] font-redacted opacity-90 pointer-events-none leading-none text-center">
                            Sign In
                        </span>
                    </div>
                </div>

                <p class="text-[#545454] text-center text-xs md:text-sm mb-4 lg:mb-6 leading-relaxed">
                    Plan your project effectively through simplified interactivity and collaboration with users around the world.
                </p>

                <form action="/dashboard" method="POST" class="space-y-3 lg:space-y-3.5">
                    <div>
                        <label class="block text-xs md:text-sm font-bold text-[#111827] mb-1">E-mail Address</label>
                        <div class="relative">
                            <input type="email" placeholder="E-mail must be appropriate" 
                                class="w-full border-2 border-gray-200 rounded-lg pl-4 pr-10 md:pr-12 py-2.5 focus:outline-none focus:border-[#14452F] focus:bg-white/80 text-xs md:text-sm transition-all text-[#111827] placeholder-gray-400 bg-white/50">
                            <div class="absolute right-3 md:right-4 top-1/2 -translate-y-1/2">
                                <x-lucide-mail class="w-4 h-4 md:w-5 md:h-5 text-[#14452F]" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs md:text-sm font-bold text-[#111827] mb-1">Password</label>
                        <div class="relative">
                            <input type="password" placeholder="Password must be 6-12 characters" 
                                class="w-full border-2 border-gray-200 rounded-lg pl-4 pr-10 md:pr-12 py-2.5 focus:outline-none focus:border-[#14452F] focus:bg-white/80 text-xs md:text-sm transition-all text-[#111827] placeholder-gray-400 bg-white/50">
                            <div class="absolute right-3 md:right-4 top-1/2 -translate-y-1/2">
                                <x-lucide-lock class="w-4 h-4 md:w-5 md:h-5 text-[#14452F]" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center mt-1">
                        <input type="checkbox" id="remember" class="w-3.5 h-3.5 md:w-4 md:h-4 text-[#14452F] border-gray-300 rounded focus:ring-[#14452F] cursor-pointer bg-white">
                        <label for="remember" class="ml-2 text-xs md:text-sm text-[#545454] cursor-pointer hover:text-[#14452F] transition-colors">Remember Me</label>
                    </div>

                    <div class="text-center text-xs md:text-sm text-[#545454] mt-3 mb-2">
                        Don't have an account? <a href="/register" class="font-bold text-[#6B7280] hover:text-[#14452F] transition-colors underline decoration-1 underline-offset-4">Get Progrest Now</a>
                    </div>

                    <button type="submit" class="w-full bg-[#14452F] hover:bg-[#217750] text-white font-bold py-2.5 md:py-3 rounded-xl transition-all shadow-md active:scale-95 text-sm md:text-base">
                        Log In
                    </button>

                    <div class="flex items-center my-2 opacity-70">
                        <hr class="flex-grow border-gray-300">
                        <span class="px-3 text-[9px] md:text-[10px] text-gray-500 font-bold uppercase tracking-wider">OR</span>
                        <hr class="flex-grow border-gray-300">
                    </div>

                    <a href="/google" class="w-full bg-white/80 border-2 border-[#14452F] text-[#111827] font-bold py-2.5 md:py-3 rounded-xl flex items-center justify-center gap-2 md:gap-3 hover:bg-white transition-all shadow-sm active:scale-95 text-sm md:text-base">
                        <img src="images/Google_Icon.png" alt="" class="w-4 h-4 md:w-5 md:h-5"> 
                        Continue with Google
                    </a>

                    <div class="text-center mt-4">
                        <a href="/forgot" class="text-xs md:text-sm font-bold text-[#6B7280] hover:text-[#14452F] transition-colors underline decoration-1 underline-offset-4">Forgot Your Password?</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="w-full lg:w-1/2 relative h-48 sm:h-64 md:h-80 lg:h-full animate-reveal delay-200 opacity-0 order-first lg:order-last shrink-0 mt-2 lg:mt-0">
            <div class="absolute top-[5%] md:top-[10%] lg:top-[12%] left-[8%] md:left-[15%] lg:left-[8%] w-[60%] md:w-[45%] lg:w-[72%] aspect-[3/2] bg-[#E9F2EE] rounded-[20px] lg:rounded-[30px] overflow-hidden shadow-lg border-2 lg:border-4 border-white transform transition-all duration-500 hover:scale-105 lg:hover:-translate-y-6 lg:hover:-translate-x-6 hover:-rotate-3 hover:z-40 z-10 hover:shadow-2xl">
                <img src="images/Teamwork_Stock.png" alt="" class="w-full h-full object-cover">
            </div>
            
            <div class="absolute bottom-[5%] md:bottom-[10%] lg:bottom-[12%] right-[8%] md:right-[15%] lg:right-[8%] w-[60%] md:w-[45%] lg:w-[72%] aspect-[3/2] bg-[#BDD7CB] rounded-[20px] lg:rounded-[30px] overflow-hidden shadow-lg border-2 lg:border-4 border-white transform transition-all duration-500 hover:scale-105 lg:hover:translate-y-6 lg:hover:translate-x-6 hover:rotate-3 hover:z-40 z-20 hover:shadow-2xl">
                <img src="images/Discuss_Stock.png" alt="" class="w-full h-full object-cover">
            </div>
        </div>
    </div>

</body>
</html>