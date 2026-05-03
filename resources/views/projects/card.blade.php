<div class="bg-background rounded-3xl p-6 shadow-sm relative pl-9 w-full max-w-sm">
    <div class="absolute left-4 top-6 bottom-24 w-1 rounded-full" style="background-color: {{ $accentColor ?? 'bg-primary' }};"></div>

    <div class="flex justify-between items-start mb-4">
        <div class="pr-2">
            <h2 class="text-text-primary text-xl font-bold font-parkinsans">{{ $title }}</h2>
            <p class="text-text-primary text-sm mt-1 leading-snug font-montserrat">{{ $description }}</p>
        </div>
        @if ($progress < 100)
            <div class="text-[#EAB308]">
                <x-lucide-clock class="w-6 h-6" />
            </div>
        @else
            <div class="text-[#22C55E]">
                <x-lucide-circle-check-big class="w-6 h-6" />
            </div>
        @endif
    </div>

    <div class="mb-4 mt-6">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-text-primary font-bold font-parkinsans">Progress</h3>
            <span class="text-text-primary font-bold font-parkinsans">{{ $progress }}%</span>
        </div>
        <div class="w-full bg-gray-200 h-1.5 rounded-full overflow-hidden">
            <div class="bg-blue-600 h-full rounded-full" style="width: {{ $progress }}%;"></div>
        </div>
    </div>

    <div class="mb-6">
        <h3 class="text-text-primary font-bold font-parkinsans mb-2">Collaborators</h3>
        <div class="flex items-center -space-x-2">
            @foreach ($collaborators as $avatar)
                <img src="{{ $avatar }}" alt="Collaborator" class="w-8 h-8 rounded-full border-2 border-white object-cover relative z-0">
            @endforeach
            
            @if ($extraCollaborators > 0)
                <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-xs font-semibold relative z-10 shadow-sm">
                    +{{ $extraCollaborators }}
                </div>
            @endif
        </div>
    </div>

    <button class="text-text-primary w-full py-2 items-center border-2 border-gray-100 shadow-sm rounded-full flex items-center justify-center gap-1 font-bold  text-sm hover:bg-surface transition-colors font-parkinsans">
        VIEW <x-lucide-eye class="w-5 h-5" />
    </button>
</div>