@props(['menu'])

<aside id="sidebar"
    class="bg-background text-black p-4 h-screen rounded-r-2xl shadow-r-xl flex flex-col gap-3 relative transition-[width] duration-300">

    <!-- Toggle Button -->
    <button id="sidebar-toggle"
        class="absolute top-4 right-5 p-2 text-text-primary rounded-lg hover:bg-tertiary w-10 rotate-0 hover:rotate-90 transition duration-300">
        ☰
    </button>

    <!-- Logo -->
    <img id="app-logo"
        src="images/progrest_logo_green.png"
        class="w-30 h-auto mt-2">

    <img id="app-logo-p"
        src="images/progrest_p_logo_green.png"
        class="hidden w-9 h-auto mt-13 mx-auto">

    <div class="w-full h-px bg-border rounded-xl"></div>

    <!-- Profile -->
    <div class="flex gap-3 border-[1.5px] p-2 border-border rounded-xl shadow-sm items-center">
        <img src="images/profile.jpg" class="w-12 rounded-4xl sidebar-icon">
        <div class="flex flex-col justify-center sidebar-text">
            <p class="font-montserrat font-bold text-text-primary">Reeders</p>
            <p class="font-montserrat -mt-px text-s text-text-secondary">Reeders Rere</p>
        </div>
    </div>

    <!-- Menu Title -->
    <p class="pt-3 font-montserrat text-xs uppercase tracking-wide font-semibold text-text-secondary opacity-80 sidebar-text">
        Menus
    </p>

    <!-- Menu Items -->
    @foreach ($menu as $group)
        @foreach ($group['navigations'] as $item)
            @php
                $isActive = request()->is(ltrim($item['path'], '/'));
            @endphp 

            <!-- ✅ FIX: <a> is now the wrapper -->
            <a href="{{ $item['path'] }}"
               class="sidebar-item group w-full h-10 
               {{ $isActive ? 'bg-tertiary shadow-sm ring-1 ring-gray-100' : 'bg-background hover:bg-tertiary' }} 
               transition duration-300 rounded-xl flex items-center gap-2 justify-start px-2">

                <!-- Active Indicator -->
                <div class="h-full w-2 -ml-2.25 
                    {{ $isActive ? 'bg-primary opacity-100' : 'opacity-0 group-hover:opacity-100' }} 
                    transition duration-300 rounded-l-xl sidebar-indicator">
                </div>

                <!-- Icon -->
                <div class="sidebar-icon p-1 rounded-md flex items-center justify-center
                    {{ $isActive ? 'bg-secondary' : 'bg-gray-300 group-hover:bg-secondary' }}">
                    
                    @if ($loop->first)
                        <x-lucide-layout-dashboard class="w-4 h-4 text-black group-hover:text-primary" />
                    @elseif ($loop->index == 1)
                        <x-lucide-folder-git-2 class="w-4 h-4 text-black group-hover:text-primary" />
                    @elseif ($loop->index == 2)
                        <x-lucide-users class="w-4 h-4 text-black group-hover:text-primary" />
                    @else
                        <x-lucide-user-pen class="w-4 h-4 text-black group-hover:text-primary" />
                    @endif 

                </div>

                <!-- Label -->
                <span class="sidebar-text block py-2 font-montserrat font-semibold 
                    {{ $isActive ? 'text-primary' : 'text-text-primary group-hover:text-primary' }}">
                    {{ $item['name'] }}
                </span>

            </a>
        @endforeach
    @endforeach

    <!-- Themes Title -->
    <p class="pt-3 font-montserrat text-xs uppercase tracking-wide font-semibold text-text-secondary opacity-80 sidebar-text">
        Themes
    </p>

    <!-- Theme Section -->
    <div class="sidebar-theme w-full rounded-xl bg-background border-[1.5px] p-3 border-border flex flex-col gap-3 items-center">

        <div class="sidebar-text flex gap-3 items-center">
            <x-lucide-palette class="w-6 h-6 text-primary"/>
            <div class="flex flex-col">
                <p class="font-montserrat text-sm font-semibold text-text-primary">Select Theme</p>
                <p class="font-montserrat text-[12px] text-text-secondary">Pick your desired theme</p>
            </div>
        </div>

        <div class="flex flex-row gap-2">
            <button class="theme-btn flex flex-col items-center gap-3 p-2 rounded-lg hover:bg-tertiary transition" data-theme="light">
                <div class="w-8 h-8 rounded-2xl overflow-hidden flex">
                    <div class="w-1/2 bg-[#FFFFFF]"></div>
                    <div class="w-1/2 bg-[#F5F4F1]"></div>
                </div>
                <span class="sidebar-text font-montserrat text-sm text-text-secondary">Light</span>
            </button>

            <button class="theme-btn flex flex-col items-center gap-3 p-2 rounded-lg hover:bg-tertiary transition" data-theme="dark">
                <div class="w-8 h-8 rounded-2xl overflow-hidden flex">
                    <div class="w-1/2 bg-[#0F172A]"></div>
                    <div class="w-1/2 bg-[#1E293B]"></div>
                </div>
                <span class="sidebar-text font-montserrat text-sm text-text-secondary">Dark</span>
            </button>

            <button class="theme-btn flex flex-col items-center gap-3 p-2 rounded-lg hover:bg-tertiary transition" data-theme="system">
                <div class="w-8 h-8 rounded-2xl overflow-hidden flex">
                    <div class="w-1/2 bg-white"></div>
                    <div class="w-1/2 bg-[#0F172A]"></div>
                </div>
                <span class="sidebar-text font-montserrat text-sm text-text-secondary">System</span>
            </button>
        </div>
    </div>

</aside>