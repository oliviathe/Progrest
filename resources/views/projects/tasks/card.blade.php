<div class="bg-background rounded-3xl p-5 shadow-sm relative pl-9 w-full flex flex-col h-full hover:shadow-md hover:-translate-y-0.5 transition-all">

    @php
        $priorityLower = strtolower($task->priority);

        $accentClass = match($priorityLower) {
            'high' => 'bg-red-accent',
            'medium' => 'bg-yellow-accent',
            'low' => 'bg-quartiary'
        };

        $avatar = "/images/profile.jpg"; 
        $image = "/images/profile.jpg"; 
    @endphp

    {{-- Floating Left Accent Line --}}
    <div class="absolute left-4 top-6 bottom-7 w-1 rounded-full {{ $accentClass }}"></div>

    {{-- HEADER ROW --}}
    <div class="flex justify-between items-center mb-3 shrink-0">
        
        {{-- Top Left: Priority --}}
        <div class="{{ $accentClass }} px-3 py-1 rounded-lg flex items-center justify-center shadow-2xs">
            <span class="font-montserrat text-white text-[12px] font-semibold uppercase tracking-wider leading-none">
                {{ $task->priority }}
            </span>
        </div>

        {{-- Top Right: Status --}}
        @if (!$task->is_completed)
            <div class="text-pastel-yellow-text flex flex-row gap-2.5 items-center">
                <div class="bg-pastel-yellow-background px-3 py-1 rounded-lg flex items-center justify-center">
                    <span class="font-montserrat text-pastel-yellow-text text-[12px] font-semibold leading-none">In Progress</span>
                </div>
                <x-lucide-clock class="w-6 h-6" />
            </div>
        @else
            <div class="text-pastel-green-text flex flex-row gap-2.5 items-center">
                <div class="bg-pastel-green-background px-3 py-1 rounded-lg flex items-center justify-center">
                    <span class="font-montserrat text-pastel-green-text text-[12px] font-semibold leading-none">Completed</span>
                </div>
                <x-lucide-circle-check-big class="w-6 h-6" />
            </div>
        @endif

    </div>

    {{-- TITLE --}}
    <div class="pr-2 flex flex-col grow">
        <h2 class="text-text-primary text-xl font-semibold font-montserrat leading-snug">
            {{ $task->title }}
        </h2>
    </div>

    {{-- IMAGE PREVIEW --}}
    <div class="my-3 shrink-0">
        @if($image)
            <img
                src="{{ $image }}"
                class="rounded-2xl w-full h-32 object-cover shadow-2xs"
            >
        @else
            <div class="h-32 rounded-2xl bg-surface/50 border border-gray-100 flex items-center justify-center text-text-secondary font-montserrat text-xs">
                No preview attached
            </div>
        @endif
    </div>

    {{-- collaborator --}}
    <div class="mb-4 shrink-0">
        <h3 class="text-text-primary font-semibold font-montserrat mb-2 text-sm">Collaborator</h3>
        <div class="flex items-center">
            @foreach ($task->users->take(3) as $user)
                <img src="{{ $user->avatar ? $user->avatar : '/images/profile.jpg' }}" class="w-8 h-8 rounded-full border-2 border-white object-cover shadow-2xs first:ml-0 -ml-2.5">
            @endforeach
            @if ($task->users->count() > 3)
                <div class="w-8 h-8 rounded-full border-2 border-white bg-surface flex items-center justify-center text-xs font-semibold text-text-primary">+{{$task->users->count() - 3}}</div>
            @endif
        </div>
    </div>

    {{-- DUE DATE & COMMENTS ROW --}}
    <div class="flex flex-row items-center justify-between mb-3 shrink-0">
        <div class="flex flex-row gap-1.5 items-center">
            <x-lucide-calendar class="w-3.5 h-3.5 text-text-secondary"/> 
            <p class="font-montserrat text-text-secondary text-sm">Due {{ $task->deadline->format('d M Y') }}</p>
        </div>

        {{-- Added Comment Counter --}}
        <div class="flex flex-row gap-1.5 items-center">
            <x-lucide-message-circle class="w-3.5 h-3.5 text-text-secondary"/> 
            <p class="font-montserrat text-text-secondary text-sm">{{ $commentsCount ?? 0 }}</p>
        </div>
    </div>

    {{-- View button --}}
    <button
        @click="open({
            id: {{ $task->id }},
            title: @js($task->title),
            description: @js($task->description),
            priority: @js($task->priority),
            status: @js($task->status),
            deadline: @js(optional($task->deadline)?->format('d M Y')),
            go_collab_enabled: @js($task->go_collab_enabled),
            go_collab_description: @js($task->go_collab_description),
            go_collab_limit: @js($task->go_collab_limit),
            go_collab_reward: @js($task->go_collab_reward),
            members: @js($task->users->map(fn ($member) => [
                'id' => $member->id,
                'name' => $member->name,
                'avatar' => $member->avatar
            ])),
            collaborators: @js(
                $task->collaborators->map(fn ($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar,
                    'pivot' => [
                        'status' => $user->pivot->status,
                        'reward_earned' => $user->pivot->reward_earned,
                        'joined_at' => optional($user->pivot->joined_at)?->format('d M Y'),
                        'completed_at' => optional($user->pivot->completed_at)?->format('d M Y'),
                    ],
                ])
            ),
            leader_id: {{ $project->leader->id }}
        })"
        class="text-text-primary w-full py-1.5 border-2 border-gray-100 shadow-sm rounded-full flex items-center justify-center gap-2 font-semibold text-sm hover:bg-surface transition-colors font-montserrat shrink-0 cursor-pointer">
            View
        <x-lucide-eye class="w-4 h-4 text-text-secondary" />
    </button>

</div>