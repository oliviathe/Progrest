@props(['menu'])

<aside class="w-64 bg-white text-white p-4 h-screen">
    @foreach ($menu as $group)
        <p class="text-black text-xs">{{ $group['title'] }}</p>

        @foreach ($group['items'] as $item)
            <a href="{{ $item['path'] }}" class="block py-2 text-black">
                {{ $item['name'] }}
            </a>
        @endforeach
    @endforeach
</aside>