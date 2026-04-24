<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progrest</title>
    <link rel="icon" href="images/progrest_p_logo_green.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

<!-- sm md lg xl  -->

<!-- Navbar -->
<nav class="fixed w-full bg-white shadow-sm z-5">
    
    <div class="flex justify-between items-center px-10 py-5">
        <!-- Logo -->
        <div class="w-30 h-8 bg-no-repeat bg-cover"
            style="background-image: url('images/progrest_logo_green.png')"></div> 

        <!-- Desktop -->
        <div class="hidden sm:flex gap-4 items-center">
            <a href="/sign-in" class="text-gray-600">Sign In</a>
            <a href="/register" class="bg-[#14452F] hover:bg-[#217750] text-white px-5 py-2 rounded-lg font-semibold">
                Get Started Free
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
        
        <a href="/sign-in" class="text-gray-600 py-2">Sign In</a>
        <a href="/register" class="bg-[#14452F] text-white px-5 py-2 rounded-lg font-semibold mb-4">
            Get Started Free
        </a>
    </div>

</nav>

<div class="pt-20"></div>

<!-- HERO -->
<section class="px-10 py-20 grid md:grid-cols-2 md:gap-6 sm:gap-12 xl:grid-cols-[2fr_3fr] gap-12 items-center bg-linear-to-r from-white to-[#E9F2EE]">

    <!-- kiri -->
    <div>
        <div class="text-white inline-block font-medium mb-4 px-6 py-3 bg-[#217750] rounded-2xl shadow-md">
            ⚙︎ Designed for teams. Built for progress.
        </div>

        <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6">
            Plan. Collaborate. <br>
            <span class="text-[#217750]">Deliver Results.</span>
        </h1>

        <p class="text-lg text-gray-600 mb-8 max-w-lg">
            Progrest helps teams plan, track, and complete projects with clarity.
            Stay aligned, meet deadlines, and achieve more—together.
        </p>

        <div class="flex gap-4 mb-6 text-md">
            <a href="/register" class="bg-[#217750] hover:bg-[#14452F] transition text-center text-white px-6 py-3 rounded-lg font-semibold shadow-md">
                Get Started Free
            </a>

            <button id="scroll-features" class="border-2 border-gray-300 bg-white  hover:bg-gray-100 text-center px-6 py-3 rounded-lg font-medium shadow-md transition">
                See How It Works
            </button>
        </div>

        <div class="flex gap-6 text-sm text-gray-500">
            <span>✔ No credit card required</span>
            <span>✔ Easy setup</span>
            <span>✔ Free plan</span>
        </div>
    </div>

    <!-- kanan (Dashboard Mock) -->
    <img 
        src="images/progrest_dashboard.png"
        class="w-full h-auto mx-auto rotate-3 shadow-2xl hover:rotate-0 transition duration-300 rounded-2xl"
    />

</section>

<section class="px-5 py-5 bg-white">
    <div class="px-5 py-15 flex flex-col items-center bg-no-repeat bg-cover gap-7 rounded-2xl" style="background-image: url('images/background_landing.jpg')">
        <img src="images/progrest_p_logo_white.png" alt="" class="h-38 w-auto">
        <div class="px-4 py-1 rounded-md bg-white text-[#14452F] font-montserrat font-bold opacity-90">🗪 Our Slogan:</div>
        <h1 class="text-5xl md:text-5xl font-semibold italic text-white w-7/8 text-center opacity-90">
                "Make Progress and Let Others do the Rest"
        </h1>
    </div>
</section>

<!-- Fiturs -->
<section id="features" class="px-10 py-20 bg-linear-to-r from-white to-[#E9F2EE] text-center">
    <p class="text-[#217750] font-medium mb-2">
        Everything you need to deliver
    </p>

    <h2 class="text-3xl font-bold mb-12">
        Powerful features for
        <span class="underline decoration-dotted decoration-5 underline-offset-5">modern teams</span>
    </h2>

    <div class="grid md:grid-cols-3 sm:grid-cols-1 gap-6">

        <div class="p-6 border-2 border-[#217750] rounded-xl hover:shadow-md transition">
            <div class="p-3 bg-[#BDD7CB] inline-block rounded-2xl">
                <x-lucide-brain-cog class="w-6 h-6 text-[##217750]" />
            </div>
            <h3 class="font-semibold text-lg mb-2">Smart Task Management</h3> 
            <p class="text-gray-600 mt-4">
                Organize tasks, set priorities, and track progress in real time.
            </p>
        </div>

        <div class="p-6 border-2 border-[#217750] rounded-xl hover:shadow-md transition">
            <div class="p-3 bg-[#BDD7CB] inline-block rounded-2xl">
                <x-lucide-handshake class="w-6 h-6 text-[##217750]" />
            </div>
            <h3 class="font-semibold text-lg mb-2">Team Collaboration</h3>
            <p class="text-gray-600 mt-4">
                Communicate, share files, and work together seamlessly.
            </p>
        </div>

        <div class="p-6 border-2 border-[#217750] rounded-xl hover:shadow-md transition">
            <div class="p-3 bg-[#BDD7CB] inline-block rounded-2xl">
                <x-lucide-file-chart-column-increasing class="w-6 h-6 text-[##217750]" />
            </div>
            <h3 class="font-semibold text-lg mb-2">Insights & Reports</h3>
            <p class="text-gray-600 mt-4">
                Get clear insights into progress, performance, and deadlines.
            </p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="px-10 py-15 flex flex-col items-center justify-center gap-10">

    <div class="h-auto w-full flex items-center justify-center">
        <img src="images/progrest_decoration2.png" alt="" class="z-2 -mr-40 max-h-50 -rotate-5 max-w-3/4 w-auto shadow-2xl rounded-2xl">
        <img src="images/progrest_decoration1.png" alt="" class="z-3 max-h-70 max-w-3/4 w-auto shadow-2xl rounded-2xl hover:scale-103 transition duration-300">
        <img src="images/progrest_decoration3.png" alt="" class="z-2 -ml-40 max-h-50 rotate-5 max-w-3/4 w-auto shadow-2xl rounded-2xl">
    </div>

    <div class="bg-[#14452F] text-white rounded-2xl p-10 flex flex-col items-center md:flex-row justify-between gap-6">

        <div class="flex flex-row items-center justify-center gap-8">
            <div class="p-2.5 flex items-center justify-center bg-white rounded-2xl">
                <x-lucide-rocket class="h-8 w-8 text-[#14452F]"/>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-2">
                    Ready to bring clarity to your projects?
                </h2>
                <p class="text-green-100">
                    Join teams already using Progrest to get things done.
                </p>
            </div>
        </div>

        <a href="/register" class="bg-white text-[#14452F] px-6 py-3 rounded-xl font-semibold hover:bg-gray-100 transition">
            Get Started Free
        </a>

    </div>
</section>

<!-- footer --> 
<footer class="bg-[#14452F] text-[#F5F7F6] px-10 py-16">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">

        <!-- brand -->
        <div class="flex flex-col gap-2 items-start">
            <img src="images/progrest_logo_white.png" alt="" class="w-40 h-auto">
            <p class="text-sm opacity-80">
                Make progress and let others do the rest.
            </p>

            <!-- CTA -->
            <a href="/register" 
                class="inline-block px-4 py-1.5 mt-2 bg-white text-[#14452F] 
                        rounded-xl font-semibold hover:bg-gray-100
                        transition-transform duration-300">
                    Get Started
            </a>
        </div>

        <!-- Product -->
        <div>
            <h2 class="font-semibold mb-3">Product</h2>
            <ul class="space-y-3 text-sm opacity-80">
                <li><a href="#" class="hover:opacity-100">Dashboard</a></li>
                <li><a href="#" class="hover:opacity-100">Projects</a></li>
                <li><a href="#" class="hover:opacity-100">Collaboration</a></li>
            </ul>
        </div>

        <!-- Company -->
        <div>
            <h2 class="font-semibold mb-3">Social Media</h2>
            <ul class="space-y-3 text-sm opacity-80">
                <li><a href="#" class="hover:opacity-100">Twitter</a></li>
                <li><a href="#" class="hover:opacity-100">Facebook</a></li>
                <li><a href="#" class="hover:opacity-100">Instagram</a></li>
            </ul>
        </div>

        <!-- Resources -->
        <div>
            <h2 class="font-semibold mb-3">Resources</h2>
            <ul class="space-y-3 text-sm opacity-80">
                <li><a href="#" class="hover:opacity-100">Help Center</a></li>
                <li><a href="#" class="hover:opacity-100">Privacy Policy</a></li>
                <li><a href="#" class="hover:opacity-100">Terms of Service</a></li>
            </ul>
        </div>

    </div>

    <!-- Bawah Footer -->
    <div class="border-t border-white/20 mt-12 pt-6 flex flex-col md:flex-row justify-between items-center text-sm opacity-70">
        <p>© 2026 Progrest. All rights reserved.</p>

        <p>Project Planner Platform</p>
    </div>
</footer>

{{-- <script src="resources/js/landing_navbar.js"></script> --}}
</body>
</html>