@php
    $isLeader = $project->leader_id === auth()->id();
    $isJoined = $project->users->contains(auth()->id());

    // kalau capacity null / 0 dianggap unlimited
    $isFull = $project->capacity &&
              $project->users_count >= $project->capacity;
@endphp

<div 
    class="collab-card bg-background rounded-xl shadow-sm overflow-hidden p-4"
    data-title="{{ strtolower($project->title) }}"
    data-description="{{ strtolower($project->description) }}"
    data-leader="{{ strtolower($project->leader->name) }}"
    data-full="{{ $isFull ? 'true' : 'false' }}"
    data-joined="{{ $isJoined ? 'true' : 'false' }}"
    data-owner="{{ $isLeader ? 'true' : 'false' }}">

    <h2 class="text-text-primary text-2xl font-bold mb-1">
        {{ $project->title }}
    </h2>

    <p class="text-text-secondary mb-4 line-clamp-2">
        {{ $project->description }}
    </p>

    <img
        src="{{ $project->cover_url ?? asset('images/project-cover.jpg') }}"
        class="w-full h-40 object-cover rounded-lg">

    <div class="flex justify-between text-xs text-gray-500 mb-4 font-semibold">

        <span>
            Joined:
            {{ $project->users_count }}

            @if($project->capacity)
                / {{ $project->capacity }}
            @else
                / ∞
            @endif
        </span>

        <span>
            Due:
            {{ optional($project->deadline)->format('d M Y') ?? 'None' }}
        </span>

    </div>

    <div class="flex items-center gap-2">

        <img
            src="{{ $project->leader->avatar_url }}"
            class="w-6 h-6 rounded-full object-cover">

        <span class="text-sm font-bold">

            {{ $project->leader->name }}

        </span>

    </div>

    {{-- BUTTON --}}
    @if($isLeader)

        <button
            class="mt-4 w-full py-2 rounded-full bg-blue-200 text-blue-700">

            OWNER

        </button>

    @elseif($isJoined)

        <button
            disabled
            class="mt-4 w-full py-2 rounded-full bg-green-100 text-green-700">

            JOINED

        </button>

    @elseif($isFull)

        <button
            disabled
            class="mt-4 w-full py-2 rounded-full bg-gray-300 text-gray-600">

            FULL

        </button>

    @else

        <button

            onclick="openJoinModal(

                '{{ $project->id }}',

                @js($project->title),

                @js($project->description),

                '{{ optional($project->deadline)->format('d M Y') }}',

                @js($project->leader->name),

                '{{ $project->users_count }}',

                '{{ $project->reward }}'

            )"

            class="mt-4 w-full py-2 rounded-full bg-primary text-white hover:opacity-90">

            VIEW

        </button>

    @endif

</div>