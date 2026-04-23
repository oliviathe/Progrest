<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progrest</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans bg-gray-50 text-gray-800">

    <nav class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-8 py-4 bg-[#F5F7F6] shadow-ms">
        <div class="w-30 h-10 bg-no-repeat bg-contain" style="background-image: url('images/progrest_logo_green.png')"></div>
        <div class="space-x-6 hidden md:block font-montserrat font-semibold text-black">
            <button class="px-4 py-2 bg-[#F5F7F6] text-black rounded-lg hover:bg-[#F5F4F1] transition">
                <a href="/home">Home</a>
            </button>
            <button class="px-4 py-2 bg-[#F5F7F6] text-black rounded-lg hover:bg-[#F5F4F1] transition">
                <a href="/home">About Us</a>
            </button>
        </div>
        <a href="/login" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            Sign In
        </a>
    </nav>

    <!-- HERO -->
    <section class="min-h-screen w-full flex items-center 
                    bg-no-repeat bg-cover p-10" style="background-image: url('images/background_landing.jpg')">

        <div class="text-center max-w-3xl">
            <h1 class="text-left text-3xl sm:text-4xl md:text-6xl lg:text-7xl font-bold leading-tight text-[#F5F7F6]">
                Manage All Your
            </h1>

            <h1 class="text-left text-3xl sm:text-4xl md:text-6xl lg:text-8xl font-bold leading-tight text-[#F5F7F6]">
                Projects Better
            </h1>

            <p class="text-lg text-white opacity-70 mb-8">
                Progrest helps you manage, track, and scale your projects effortlessly with a clean and modern workflow.
            </p>

            <div class="space-x-4">
                <a href="/register" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">
                    Get Started
                </a>
                <a href="#" class="border border-gray-300 px-6 py-3 rounded-lg hover:bg-gray-100">
                    Learn More
                </a>
            </div>
        </div>

    </section>

    <!-- FEATURES -->
    <section class="py-20 px-6 bg-white">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-12">Why Choose Progrest?</h2>

            <div class="grid md:grid-cols-3 gap-8">
                
                <div class="p-6 rounded-xl shadow-sm hover:shadow-md transition">
                    <h3 class="text-xl font-semibold mb-3">Fast Performance</h3>
                    <p class="text-gray-600">
                        Optimized for speed so you can focus on productivity.
                    </p>
                </div>

                <div class="p-6 rounded-xl shadow-sm hover:shadow-md transition">
                    <h3 class="text-xl font-semibold mb-3">Easy to Use</h3>
                    <p class="text-gray-600">
                        Simple interface designed for developers and teams.
                    </p>
                </div>

                <div class="p-6 rounded-xl shadow-sm hover:shadow-md transition">
                    <h3 class="text-xl font-semibold mb-3">Scalable</h3>
                    <p class="text-gray-600">
                        Grow your projects without worrying about limitations.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 bg-blue-500 text-white text-center">
        <h2 class="text-3xl font-bold mb-4">
            Ready to get started?
        </h2>
        <p class="mb-6">
            Join thousands of users building amazing products.
        </p>

        <a href="/register" class="bg-white text-blue-500 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">
            Create Account
        </a>
    </section>

    <!-- FOOTER -->
    <footer class="py-6 text-center text-gray-500 bg-gray-100">
        © {{ date('Y') }} Progrest. All rights reserved.
    </footer>

</body>
</html>