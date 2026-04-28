<div class="flex min-h-screen bg-[#F5F4F1]">
    <x-sidebar :menu="$menu" />

    <main class="flex-1 p-6">
        @yield('content')
    </main>
</div>