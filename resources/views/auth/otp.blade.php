<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OTP Verification - Progrest</title>

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
            <img id="logo-auth" src="/images/progrest_logo_green.png" alt="Progrest" class="h-8 w-auto hover:scale-105 transition duration-300 cursor-pointer">
        </div>

        <div class="w-full lg:w-1/2 p-5 lg:px-12 flex flex-col justify-center relative z-10 h-full animate-reveal delay-100 opacity-0">

            <div class="w-full max-w-md mx-auto">

                <div class="relative w-full flex items-center justify-center mb-3 mt-0">
                    <div class="absolute left-0">
                        <a href="{{ route('forgot') }}" class="w-9 h-9 md:w-10 md:h-10 bg-primary hover:bg-[#217750] text-white rounded-full flex items-center justify-center transition-colors shadow-sm cursor-pointer">
                            <x-lucide-corner-up-left class="w-4 h-4 md:w-5 md:h-5 stroke-[2.5px]" />
                        </a>
                    </div>

                    <div class="relative w-max">
                        <h1 class="text-3xl md:text-[2.3rem] text-center font-bold text-primary font-montserrat tracking-wide leading-none">{{ __('main.auth.otp-title') }}</h1>
                        <span class="text-text-primary absolute top-1/2 left-1/2 -translate-x-1/2 translate-y-[-45%] w-[115%] text-3xl md:text-[3rem] font-redacted opacity-90 pointer-events-none leading-none text-center">
                            {{ __('main.auth.otp-title') }}
                        </span>
                    </div>
                </div>

                <p class="text-text-secondary text-center text-sm md:text-sm mb-3 lg:mb-5 leading-relaxed">
                    {{ __('main.auth.otp-desc') }}
                </p>

                <form action="/otp" method="POST" class="space-y-4">
                    @csrf

                    <input type="hidden" name="otp" id="otp-value">

                    <div>
                        <label class="block text-xs md:text-sm font-bold text-text-primary mb-3 text-center">
                            {{ __('main.auth.verification-code') }}
                        </label>

                        <div class="flex justify-center gap-2 md:gap-3">
                            <input type="text" maxlength="1" required class="otp-input w-11 h-11 md:w-12 md:h-12 text-center text-lg md:text-xl font-bold border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary transition-all bg-background focus:bg-surface">
                            <input type="text" maxlength="1" required class="otp-input w-11 h-11 md:w-12 md:h-12 text-center text-lg md:text-xl font-bold border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary transition-all bg-background focus:bg-surface">
                            <input type="text" maxlength="1" required class="otp-input w-11 h-11 md:w-12 md:h-12 text-center text-lg md:text-xl font-bold border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary transition-all bg-background focus:bg-surface">
                            <input type="text" maxlength="1" required class="otp-input w-11 h-11 md:w-12 md:h-12 text-center text-lg md:text-xl font-bold border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary transition-all bg-background focus:bg-surface">
                            <input type="text" maxlength="1" required class="otp-input w-11 h-11 md:w-12 md:h-12 text-center text-lg md:text-xl font-bold border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary transition-all bg-background focus:bg-surface">
                            <input type="text" maxlength="1" required class="otp-input w-11 h-11 md:w-12 md:h-12 text-center text-lg md:text-xl font-bold border-2 border-gray-200 rounded-lg focus:outline-none focus:border-primary transition-all bg-background focus:bg-surface">
                        </div>
                    </div>

                    @if (session('error_message'))
                        <div class="text-red-500 text-sm mt-px text-center">{{ session('error_message') }}</div>
                    @endif

                    <button type="submit"
                        class="text-text-contrast w-full bg-primary hover:bg-primary-hover font-bold py-2.5 md:py-2 rounded-xl transition-all shadow-md active:scale-95 text-sm md:text-base">
                        {{ __('main.auth.verify-btn') }}
                    </button>

                    <div class="text-center text-xs md:text-sm text-text-secondary">
                        {{ __('main.auth.no-otp') }}
                        <button type="button" class="font-bold text-primary hover:text-primary-hover hover:underline transition">
                            {{ __('main.auth.resend') }}
                        </button>
                    </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const inputs = document.querySelectorAll('.otp-input');
            const form = document.querySelector('form');

            inputs.forEach((input, index) => {

                input.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');

                    if (this.value && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', function (e) {
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

            });

            form.addEventListener('submit', function (e) {

                let otp = '';
                let filled = true;

                inputs.forEach(input => {
                    if (input.value === '') {
                        filled = false;
                    }
                    otp += input.value;
                });

                if (!filled) {
                    e.preventDefault();
                    inputs.forEach(input => {
                        if (input.value === '') {
                            input.focus();
                            input.reportValidity();
                            input.setCustomValidity('Fill this field');
                            input.setCustomValidity('');
                        }
                    });
                    return;
                }

                document.getElementById('otp-value').value = otp;
            });

        });
    </script>

</body>
</html>