@props(['menu'])

<aside class="w-64 bg-white text-white p-4 h-screen rounded-r-2xl shadow-r-xl flex flex-col justify-between">

    <div class=" flex flex-col gap-3">
        <img src="images/progrest_logo_green.png" alt="" class="w-30 h-auto mt-2">

        <div class="w-full h-px bg-gray-200 rounded-xl"></div>

        <div class="flex text-black gap-3 border-[1.5px] p-2 border-gray-200 rounded-xl">
            <img src="images/profile.jpg" alt="" class="w-12 rounded-4xl">
            <div class="flex flex-col justify-center">
                <p class="font-montserrat font-bold">Reeders</p>
                <p class="font-montserrat -mt-px text-sm">Reeders Rere</p>
            </div>
        </div>

        <p class="font-montserrat text-xs uppercase tracking-wide text-gray-500 font-semibold">Menus</p>

        @foreach ($menu as $group)

            @foreach ($group['navigations'] as $item)
                <div class="w-full h-10 bg-white hover:bg-[#F4F7F5] hover:shadow-sm hover:ring-1 hover:ring-gray-100 transition duration-300 p-3 rounded-xl text-center flex items-center gap-2">
                    
                    <div class="p-1 bg-gray-300 rounded-md">
                        @if ($loop->first)
                            <x-lucide-layout-dashboard class="w-4 h-4 text-black" />
                        @elseif ($loop->index == 1)
                            <x-lucide-folder-git-2 class="w-4 h-4 text-black" />
                        @elseif ($loop->index == 2)
                            <x-lucide-users class="w-4 h-4 text-black" />
                        @else
                            <x-lucide-user-pen class="w-4 h-4 text-black" />
                        @endif 
                    </div>

                    <a href="{{ $item['path'] }}" class="block py-2 text-black font-montserrat font-semibold">
                        {{ $item['name'] }}
                    </a>

                </div>
            @endforeach
        @endforeach

        <p class="font-montserrat text-xs uppercase tracking-wide text-gray-500 font-semibold">Themes</p>
    </div>



    <div class="w-full h-50 bg-black"></div>
</aside>