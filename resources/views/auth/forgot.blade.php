<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password - Progrest</title>

    <link rel="icon" href="images/progrest_p_logo_green.png">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400..800;1,400..800&family=Redacted+Script:wght@400;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js']) 

    <style>
        .font-montserrat { font-family: 'Montserrat', sans-serif; }
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
<body class="font-montserrat antialiased min-h-screen lg:h-screen w-full bg-cover bg-center bg-no-repeat flex items-center justify-center p-4 py-8 md:p-8 overflow-x-hidden lg:overflow-hidden" 
    style="background-image: url('images/Checker_BG.png');">

    <div class="w-full max-w-85 md:max-w-2xl lg:max-w-6xl h-auto lg:h-[85vh] lg:max-h-212.5 min-h-min lg:min-h-150 bg-background backdrop-blur-md rounded-[30px] lg:rounded-[40px] shadow-2xl flex flex-col lg:flex-row relative animate-reveal">
        
        <div class="absolute top-6 right-8 hidden lg:block z-50">
            <img id="logo-auth" src="images/progrest_logo_green.png" alt="Progrest" class="h-8 w-auto hover:scale-105 transition duration-300 cursor-pointer">
        </div>

        <div class="w-full lg:w-1/2 p-5 lg:px-12 flex flex-col justify-center relative z-10 h-full animate-reveal delay-100 opacity-0">
            <div class="w-full max-w-md mx-auto">
                
                <div class="relative w-full flex items-center justify-center mb-3 mt-0">
                    <div class="absolute left-0">
                        <a href="{{ route('login') }}" class="w-9 h-9 md:w-10 md:h-10 bg-primary hover:bg-[#217750] text-white rounded-full flex items-center justify-center transition-colors shadow-sm cursor-pointer">
                            <x-lucide-corner-up-left class="w-4 h-4 md:w-5 md:h-5 stroke-[2.5px]" />
                        </a>
                    </div>
                    <div class="relative w-max">
                        <h1 class="text-3xl md:text-[2.3rem] text-center font-bold text-primary font-montserrat tracking-wide leading-none">Forgot Password</h1>
                        <span class="text-text-primary absolute top-1/2 left-1/2 -translate-x-1/2 translate-y-[-45%] w-[115%] text-3xl md:text-[3rem] font-redacted opacity-90 pointer-events-none leading-none text-center">
                            Forgot Password
                        </span>
                    </div>
                </div>

                <p class="text-text-secondary text-center text-sm md:text-sm mb-3 lg:mb-5 leading-relaxed">
                    Enter your email address to receive a verification code for resetting your password.
                </p>

                <form action="/forgot" method="POST" class="space-y-4">
                    @csrf

                    <div class="group">
                        <label class="block text-xs md:text-sm font-bold text-text-primary mb-1">
                            Email Address
                        </label>

                        <div class="relative">
                            <input
                                type="email"
                                name="email"
                                required
                                placeholder="Enter your email address"
                                class="text-text-primary w-full border-2 border-gray-200 rounded-lg pl-4 pr-10 md:pr-12 py-2.5 md:py-2 focus:outline-none focus:border-primary text-xs md:text-sm transition-all placeholder-text-secondary/50 bg-background focus:bg-surface">

                            <div class="absolute right-3 md:right-4 top-1/2 -translate-y-1/2">
                                <x-lucide-mail class="w-4 h-4 md:w-5 md:h-5 text-primary"/>
                            </div>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="text-text-contrast w-full bg-primary hover:bg-primary-hover font-bold py-2.5 md:py-2 rounded-xl transition-all shadow-md active:scale-95 text-sm md:text-base">
                        Send Verification OTP
                    </button>

                </form>
            </div>
        </div>

        <div class="w-full lg:w-1/2 relative h-40 sm:h-56 lg:h-full animate-reveal delay-200 opacity-0 order-first lg:order-last shrink-0 mt-2 lg:mt-0">
            <div class="absolute top-[5%] lg:top-[12%] left-[8%] lg:left-[8%] w-[60%] lg:w-[72%] aspect-[3/2] bg-[#E9F2EE] rounded-[20px] lg:rounded-[30px] overflow-hidden shadow-lg border-2 lg:border-4 border-white transform transition-all duration-500 hover:scale-105 lg:hover:-translate-y-6 lg:hover:-translate-x-6 hover:-rotate-3 hover:z-40 z-10 hover:shadow-2xl">
                <img src="images/Teamwork_Stock.png" alt="" class="w-full h-full object-cover">
            </div>
            
            <div class="absolute bottom-[5%] lg:bottom-[12%] right-[8%] lg:right-[8%] w-[60%] lg:w-[72%] aspect-[3/2] bg-[#BDD7CB] rounded-[20px] lg:rounded-[30px] overflow-hidden shadow-lg border-2 lg:border-4 border-white transform transition-all duration-500 hover:scale-105 lg:hover:translate-y-6 lg:hover:translate-x-6 hover:rotate-3 hover:z-40 z-20 hover:shadow-2xl">
                <img src="images/Discuss_Stock.png" alt="" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</body>
</html>