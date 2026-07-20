<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password - Progrest</title>

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
            <img src="/_green.png" class="h-8 w-auto hover:scale-105 transition duration-300">
        </div>

        <div class="w-full lg:w-1/2 p-5 lg:px-12 flex flex-col justify-center relative z-10 h-full animate-reveal delay-100 opacity-0">

            <div class="w-full max-w-md mx-auto">

                <div class="relative w-full flex items-center justify-center mb-3">
                    <div class="absolute left-0">
                        <a href="{{ route('otp') }}"
                            class="w-9 h-9 md:w-10 md:h-10 bg-primary hover:bg-[#217750] text-white rounded-full flex items-center justify-center transition-colors shadow-sm">
                            <x-lucide-corner-up-left class="w-4 h-4 md:w-5 md:h-5 stroke-[2.5px]" />
                        </a>
                    </div>

                    <div class="relative w-max">
                        <h1 class="text-3xl md:text-[2.3rem] font-bold text-primary font-montserrat">
                            {{ __('main.auth.reset-title') }}
                        </h1>
                        <span class="text-text-primary absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[115%] text-3xl md:text-[2.7rem] font-redacted opacity-90 pointer-events-none text-center">
                            {{ __('main.auth.reset-title') }}
                        </span>
                    </div>
                </div>

                <p class="text-text-secondary text-center text-sm mb-5 leading-relaxed">
                    {{ __('main.auth.reset-desc') }}
                </p>

                <form action="/reset-password" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs md:text-sm font-bold text-text-primary mb-1">
                            {{ __('main.auth.new-password') }}
                        </label>

                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                required
                                minlength="8"
                                placeholder="{{ __('main.ph.new-password') }}"
                                class="w-full border-2 border-gray-200 rounded-lg pl-4 pr-20 py-2.5 focus:outline-none focus:border-primary text-xs md:text-sm bg-background text-text-primary">

                            <button type="button"
                                class="absolute right-10 top-1/2 -translate-y-1/2 text-primary"
                                onclick="togglePassword('password', this)">
                                <x-lucide-eye class="w-5 h-5" />
                            </button>

                            <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                <x-lucide-lock class="w-4 h-4 md:w-5 md:h-5 text-primary" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs md:text-sm font-bold text-text-primary mb-1">
                            {{ __('main.auth.confirm-password') }}
                        </label>

                        <div class="relative">
                            <input
                                type="password"
                                name="password_confirmation"
                                required
                                minlength="8"
                                placeholder="{{ __('main.ph.confirm-password') }}"
                                class="w-full border-2 border-gray-200 rounded-lg pl-4 pr-20 py-2.5 focus:outline-none focus:border-primary text-xs md:text-sm bg-background text-text-primary">

                            <button type="button"
                                class="absolute right-10 top-1/2 -translate-y-1/2 text-primary"
                                onclick="togglePassword('password_confirmation', this)">
                                <x-lucide-eye class="w-5 h-5" />
                            </button>

                            <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                <x-lucide-lock class="w-4 h-4 md:w-5 md:h-5 text-primary" />
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-primary hover:bg-primary-hover text-text-contrast font-bold py-2.5 rounded-xl shadow-md active:scale-95 transition-all">
                        {{ __('main.auth.reset-btn') }}
                    </button>
                </form>

            </div>
        </div>

        <div class="w-full lg:w-1/2 relative h-40 sm:h-56 lg:h-full animate-reveal delay-200 opacity-0 order-first lg:order-last">
            <div class="absolute top-[10%] left-[10%] w-[70%] aspect-[3/2] rounded-[20px] overflow-hidden shadow-lg border-4 border-white">
                <img src="images/Teamwork_Stock.png" class="w-full h-full object-cover">
            </div>

            <div class="absolute bottom-[10%] right-[10%] w-[70%] aspect-[3/2] rounded-[20px] overflow-hidden shadow-lg border-4 border-white">
                <img src="images/Discuss_Stock.png" class="w-full h-full object-cover">
            </div>
        </div>

    </div>

    <script>
        function togglePassword(fieldName, btn) {
            const input = document.querySelector(`input[name="${fieldName}"]`);

            const eye = `<x-lucide-eye class="w-5 h-5" />`;
            const eyeOff = `<x-lucide-eye-off class="w-5 h-5" />`;

            if (input.type === "password") {
                input.type = "text";
                btn.innerHTML = eyeOff;
            } else {
                input.type = "password";
                btn.innerHTML = eye;
            }
        }
    </script>

</body>
</html>