<div class="bg-background rounded-3xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all flex flex-col overflow-hidden">

    @php
        $priorityLower = strtolower($task->priority);

        $accentClass = match($priorityLower) {
            'high' => 'bg-red-accent',
            'medium' => 'bg-yellow-accent',
            default => 'bg-quartiary'
        };
    @endphp

    {{-- Hero Image --}}
    <div class="-m-5 mb-4 relative">
        <img
            src="{{ str_starts_with($task->image, '/images/')
                ? $task->image
                : asset('storage/'.$task->image) }}"
            class="w-full h-44 object-cover"
        >

        {{-- Priority --}}
        <div class="absolute top-4 left-4">
            <div class="{{ $accentClass }} px-3 py-1 rounded-lg shadow-sm flex items-center">
                <span class="text-white text-xs font-semibold uppercase font-montserrat leading-6">
                    {{ $task->priority }}
                </span>
            </div>
        </div>

        {{-- Reward --}}
        <div class="absolute top-4 right-4">
            <div class="bg-white/90 backdrop-blur px-3 py-1 rounded-lg flex items-center gap-1 shadow-sm">
                <x-lucide-star class="w-4 h-4 text-yellow-500"/>
                <span class="font-semibold text-sm text-text-primary">
                    {{ $task->go_collab_reward }} pts
                </span>
            </div>
        </div>
    </div>

    {{-- Project --}}
    <div class="flex items-center gap-2 text-sm text-text-secondary mb-2">
        <x-lucide-folder class="w-4 h-4"/>
        <span class="font-montserrat">
            {{ $task->project->title }}
        </span>
    </div>

    {{-- Title --}}
    <h2 class="text-xl font-bold font-montserrat text-text-primary leading-snug">
        {{ $task->title }}
    </h2>

    {{-- Hosted by --}}
    <div class="flex items-center gap-2 mt-3">
        <img
            src="{{ $task->project->leader->avatar ?: '/images/profile.jpg' }}"
            class="w-8 h-8 rounded-full object-cover"
        >
        <div class="flex flex-col">
            <span class="text-xs text-text-secondary font-montserrat">
                Hosted by
            </span>
            <span class="font-semibold text-sm text-text-primary font-montserrat">
                {{ $task->project->leader->name }}
            </span>
        </div>
    </div>

    {{-- Collaboration Description --}}
    <div class="mt-4">
        <p class="text-sm text-text-secondary leading-relaxed line-clamp-3">
            {{ $task->go_collab_description }}
        </p>
    </div>

    {{-- Divider --}}
    <div class="border-t border-border my-4"></div>

    {{-- Bottom Stats --}}
    <div class="grid grid-cols-2 gap-4">

        {{-- Collaborators --}}
        <div>
            <p class="text-xs text-text-secondary font-montserrat mb-1">
                Collaborators
            </p>
            <div class="flex items-center gap-2">
                <div class="flex">
                    @foreach($task->users->take(3) as $user)
                        <img
                            src="{{ $user->avatar ?: '/images/profile.jpg' }}"
                            class="w-8 h-8 rounded-full border-2 border-white -ml-2 first:ml-0 object-cover"
                        >
                    @endforeach
                </div>
                <span class="text-sm font-semibold text-text-primary">
                    {{ $task->users->count() }} / {{ $task->go_collab_limit }}
                </span>
            </div>
        </div>

        {{-- Deadline --}}
        <div>
            <p class="text-xs text-text-secondary font-montserrat mb-1">
                Deadline
            </p>
            @if($task->deadline)

                @php
                    $days = now()->diffInDays($task->deadline, false);
                @endphp

                @if($days < 0)
                    <span class="text-red-500 font-semibold text-sm">
                        Overdue
                    </span>
                @elseif($days == 0)
                    <span class="text-yellow-500 font-semibold text-sm">
                        Due Today
                    </span>
                @else
                    <span class="text-text-primary font-semibold text-sm">
                        {{ $days }} days left
                    </span>
                @endif
            @else
                <span class="text-text-secondary text-sm">
                    No deadline
                </span>
            @endif
        </div>
    </div>

    {{-- Join Button --}}
    <div class="mt-5">
        @if($task->users->count() >= $task->go_collab_limit)
            <button
                disabled
                class="w-full rounded-full py-2.5 bg-gray-300 text-gray-600 font-semibold cursor-not-allowed"
            >
                Collaboration Full
            </button>
        @else
            <button
                class="w-full rounded-full py-2.5 bg-primary hover:bg-primary/90 text-white font-semibold transition-colors flex justify-center items-center gap-2"
            >
                Join Collaboration
                <x-lucide-arrow-right class="w-4 h-4"/>
            </button>
        @endif
    </div>
</div>