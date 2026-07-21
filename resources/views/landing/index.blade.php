<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progrest</title>
    <link rel="icon" href="images/progrest_p_logo_green.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-primary">

<!-- Navbar -->
<nav class="fixed w-full bg-background shadow-sm z-5">
    
    <div class="flex justify-between items-center px-10 py-5">
        <!-- Logo -->
        <img id="logo-landing" src="/images/progrest_logo_green.png" alt="" class="w-30">

        <!-- Desktop -->
        <div class="hidden sm:flex gap-4 items-center">
            <div class="flex items-center rounded-lg border border-border p-0.5 font-montserrat text-sm font-semibold">
                <a href="{{ route('language.switch', 'en') }}" class="px-3 py-1 rounded-md transition-colors {{ app()->getLocale() == 'en' ? 'bg-primary text-white' : 'text-text-secondary hover:text-text-primary' }}">EN</a>
                <a href="{{ route('language.switch', 'id') }}" class="px-3 py-1 rounded-md transition-colors {{ app()->getLocale() == 'id' ? 'bg-primary text-white' : 'text-text-secondary hover:text-text-primary' }}">ID</a>
            </div>
            <a href="{{ route('login') }}" class="text-text-primary font-montserrat">{{ __('main.landing.signin') }}</a>
            <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-hover text-white px-5 py-2 rounded-lg font-semibold font-montserrat">
                {{ __('main.landing.get-started-free') }}
            </a>
        </div>

        <!-- Hamburger -->
        <button id="menu-btn" class="sm:hidden text-2xl hover:rotate-90 transition duration-300">
            ☰
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out flex flex-col items-center gap-4 px-10">
        
        <a href="{{ route('login') }}" class="text-gray-600 py-2 font-montserrat">{{ __('main.landing.signin') }}</a>
        <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-hover text-white px-5 py-2 rounded-lg font-semibold mb-4 font-montserrat">
            {{ __('main.landing.get-started-free') }}
        </a>
        <div class="flex items-center rounded-lg border border-border p-0.5 mb-4 font-montserrat text-sm font-semibold">
            <a href="{{ route('language.switch', 'en') }}" class="px-3 py-1 rounded-md transition-colors {{ app()->getLocale() == 'en' ? 'bg-primary text-white' : 'text-text-secondary hover:text-text-primary' }}">EN</a>
            <a href="{{ route('language.switch', 'id') }}" class="px-3 py-1 rounded-md transition-colors {{ app()->getLocale() == 'id' ? 'bg-primary text-white' : 'text-text-secondary hover:text-text-primary' }}">ID</a>
        </div>
    </div>

</nav>

<div class="pt-20"></div>

<!-- HERO -->
<section class="px-10 py-20 grid md:grid-cols-2 md:gap-6 sm:gap-12 xl:grid-cols-[2fr_3fr] gap-12 items-center bg-linear-to-r from-surface to-background-gradient">

    <!-- kiri -->
    <div>
        <div class="font-montserrat text-white inline-block font-medium mb-4 px-6 py-3 bg-[#217750] rounded-2xl shadow-md">
            {{ __('main.landing.badge') }}
        </div>

        <h1 class="font-montserrat text-text-primary text-5xl md:text-6xl font-bold leading-tight mb-6">
            {{ __('main.landing.hero-title-1') }} <br>
            <span class="text-primary">{{ __('main.landing.hero-title-2') }}</span>
        </h1>

        <p class="font-montserrat text-lg text-text-secondary mb-8 max-w-lg">
            {{ __('main.landing.hero-desc') }}
        </p>

        <div class="flex gap-4 mb-6 text-md items-center">
            <a href="{{ route('register') }}" class="font-montserrat bg-primary hover:bg-primary-hover transition text-center text-white px-6 py-3 rounded-lg font-semibold shadow-md">
                {{ __('main.landing.get-started-free') }}
            </a>
            <button id="scroll-features" class="font-montserrat border-2 text-primary border-light-border bg-background  hover:bg-light-border-hover text-center px-6 py-3 rounded-lg font-medium shadow-md transition">
                {{ __('main.landing.see-how') }}
            </button>
        </div>

        <div class="font-montserrat flex gap-6 text-sm text-text-secondary">
            <span>{{ __('main.landing.perk-no-card') }}</span>
            <span>{{ __('main.landing.perk-easy-setup') }}</span>
            <span>{{ __('main.landing.perk-free-plan') }}</span>
        </div>
    </div>

    <!-- kanan (Dashboard Mock) -->
    <img 
        src="images/progrest_dashboard.png"
        class="w-full h-auto mx-auto rotate-3 shadow-2xl hover:rotate-0 transition duration-300 rounded-2xl"
    />

</section>

<section class="px-5 py-5 bg-background">
    <div class="px-5 py-15 flex flex-col items-center bg-no-repeat bg-cover gap-7 rounded-2xl" style="background-image: url('images/background_landing.jpg')">
        <img src="images/progrest_p_logo_white.png" alt="" class="h-38 w-auto">
        <div class="px-4 py-1 rounded-md bg-white text-primary font-montserrat font-bold opacity-90">{{ __('main.landing.slogan-label') }}</div>
        <h1 class="font-montserrat text-4xl md:text-4xl font-semibold italic text-white w-7/8 text-center opacity-90">
                {{ __('main.landing.slogan') }}
        </h1>
    </div>
</section>

<!-- Fiturs -->
<section id="features" class="px-10 py-20 bg-linear-to-r from-background to-background-gradient text-center">
    <p class="text-secondary font-montserrat font-medium mb-2">
        {{ __('main.landing.features-eyebrow') }}
    </p>

    <h2 class="font-montserrat text-3xl font-bold mb-12 text-text-primary">
        {{ __('main.landing.features-title-1') }}
        <span class="underline decoration-dotted decoration-5 underline-offset-5 text-primary">{{ __('main.landing.features-title-2') }}</span>
    </h2>

    <div class="grid md:grid-cols-3 sm:grid-cols-1 gap-6">

        <div class="p-6 border-2 border-[#217750] rounded-xl hover:shadow-md transition">
            <div class="p-3 bg-[#BDD7CB] inline-block rounded-2xl">
                <x-lucide-brain-cog class="w-6 h-6 text-[#217750]" />
            </div>
            <h3 class="font-montserrat font-semibold text-lg mb-2 text-text-primary">{{ __('main.landing.feature-1-title') }}</h3>
            <p class="mt-4 font-montserrat text-text-secondary">
                {{ __('main.landing.feature-1-desc') }}
            </p>
        </div>

        <div class="p-6 border-2 border-[#217750] rounded-xl hover:shadow-md transition">
            <div class="p-3 bg-[#BDD7CB] inline-block rounded-2xl">
                <x-lucide-handshake class="w-6 h-6 text-[#217750]" />
            </div>
            <h3 class="font-montserrat font-semibold text-lg mb-2 text-text-primary">{{ __('main.landing.feature-2-title') }}</h3>
            <p class="font-montserrat text-text-secondary mt-4">
                {{ __('main.landing.feature-2-desc') }}
            </p>
        </div>

        <div class="p-6 border-2 border-[#217750] rounded-xl hover:shadow-md transition">
            <div class="p-3 bg-[#BDD7CB] inline-block rounded-2xl">
                <x-lucide-file-chart-column-increasing class="w-6 h-6 text-[#217750]" />
            </div>
            <h3 class="font-montserrat font-semibold text-lg mb-2 text-text-primary">{{ __('main.landing.feature-3-title') }}</h3>
            <p class="font-montserrat text-text-secondary mt-4">
                {{ __('main.landing.feature-3-desc') }}
            </p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="px-10 py-15 flex flex-col items-center justify-center gap-10 bg-background">

    <div class="h-auto w-full flex items-center justify-center">
        <img src="images/progrest_decoration2.png" alt="" class="z-2 -mr-40 max-h-50 -rotate-5 max-w-3/4 w-auto shadow-2xl rounded-2xl">
        <img src="images/progrest_decoration1.png" alt="" class="z-3 max-h-70 max-w-3/4 w-auto shadow-2xl rounded-2xl hover:scale-103 transition duration-300">
        <img src="images/progrest_decoration3.png" alt="" class="z-2 -ml-40 max-h-50 rotate-5 max-w-3/4 w-auto shadow-2xl rounded-2xl">
    </div>

    <div class="bg-primary text-text-contrast rounded-2xl p-10 flex flex-col items-center md:flex-row justify-between gap-6">

        <div class="flex flex-row items-center justify-center gap-8">
            <div class="p-2.5 flex items-center justify-center bg-background rounded-2xl">
                <x-lucide-rocket class="h-8 w-8 text-primary"/>
            </div>
            <div>
                <h2 class="font-montserrat text-2xl font-bold mb-2 text-text-contrast">
                    {{ __('main.landing.cta-title') }}
                </h2>
                <p class="font-montserrat text-text-contrast opacity-90">
                    {{ __('main.landing.cta-desc') }}
                </p>
            </div>
        </div>

        <a href="/register" class="font-montserrat bg-background text-primary px-6 py-3 rounded-xl font-semibold hover:bg-light-border-hover transition">
            {{ __('main.landing.get-started-free') }}
        </a>

    </div>
</section>

<!-- footer --> 
<footer class="bg-primary text-[#F5F7F6] px-10 py-16">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">

        <!-- brand -->
        <div class="flex flex-col gap-2 items-start">
            <img id="logo-footer" src="/images/progrest_logo_white.png" alt="" class="w-40 h-auto">
            <p class="font-montserrat text-sm opacity-80 text-text-contrast">
                {{ __('main.footer.tagline') }}
            </p>

            <!-- CTA -->
            <a href="/register"
                class="font-montserrat inline-block px-4 py-1.5 mt-2 bg-background text-primary
                        rounded-xl font-semibold hover:bg-light-border-hover
                        transition-transform duration-300">
                    {{ __('main.landing.get-started') }}
            </a>
        </div>

        <!-- Product -->
        <div>
            <h2 class="font-montserrat font-semibold mb-3 text-text-contrast">{{ __('main.footer.product') }}</h2>
            <ul class="font-montserrat space-y-3 text-sm opacity-80 text-text-contrast">
                <li><a href="#" class="hover:opacity-100">{{ __('main.footer.dashboard') }}</a></li>
                <li><a href="#" class="hover:opacity-100">{{ __('main.footer.projects') }}</a></li>
                <li><a href="#" class="hover:opacity-100">{{ __('main.footer.collaboration') }}</a></li>
            </ul>
        </div>

        <!-- Company -->
        <div>
            <h2 class="font-montserrat font-semibold mb-3 text-text-contrast">{{ __('main.footer.social-media') }}</h2>
            <ul class="font-montserrat space-y-3 text-sm opacity-80 text-text-contrast">
                <li><a href="#" class="hover:opacity-100">Twitter</a></li>
                <li><a href="#" class="hover:opacity-100">Facebook</a></li>
                <li><a href="#" class="hover:opacity-100">Instagram</a></li>
            </ul>
        </div>

        <!-- Resources -->
        <div>
            <h2 class="font-montserrat font-semibold mb-3 text-text-contrast">{{ __('main.footer.resources') }}</h2>
            <ul class="font-montserrat space-y-3 text-sm opacity-80 text-text-contrast">
                <li><a href="#" class="hover:opacity-100">{{ __('main.footer.help-center') }}</a></li>
                <li><a href="#" class="hover:opacity-100">{{ __('main.footer.privacy-policy') }}</a></li>
                <li><a href="#" class="hover:opacity-100">{{ __('main.footer.terms') }}</a></li>
            </ul>
        </div>

    </div>

    <!-- Bawah Footer -->
    <div class="font-montserrat text-text-contrast border-t border-white/20 mt-12 pt-6 flex flex-col md:flex-row justify-between items-center text-sm opacity-70">
        <p>{{ __('main.footer.rights') }}</p>

        <p>{{ __('main.footer.platform') }}</p>
    </div>
</footer>

</body>
</html>