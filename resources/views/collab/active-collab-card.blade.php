<div class="bg-background rounded-3xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all flex flex-col overflow-hidden">

    @php
        $priorityLower = strtolower($task->priority);

        $accentClass = match($priorityLower) {
            'high' => 'bg-red-accent',
            'medium' => 'bg-yellow-accent',
            default => 'bg-quartiary'
        };

        $collaboration = $task->collaborations
            ->firstWhere('user_id', auth()->id());

        $submission = $task->activeSubmission;

        $isLeader = auth()->id() === $task->project->leader_id;
        $isCollaborator = $collaboration !== null;
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

        {{-- Status --}}
        <div class="absolute top-4 right-4">
            <div class="bg-white/90 backdrop-blur px-2 py-1.5 rounded-lg flex items-center gap-1 shadow-sm">
                @if ($task->status === 'pending')
                    <x-lucide-hourglass class="w-4 h-4 text-pastel-blue-text" />
                @elseif ($task->status === 'completed')
                    <x-lucide-circle-check-big class="w-4 h-4 text-pastel-green-text" />
                @elseif ($task->status === 'cancelled')
                    <x-lucide-circle-x class="w-4 h-4 text-pastel-red-text" />
                @else
                    <x-lucide-clock class="w-4 h-4 text-pastel-yellow-text" />
                @endif

                <span class="font-semibold text-[12px] text-black/80 font-montserrat ml-1">
                    {{ $task->status === 'pending' ? 'Pending' : ($task->status === 'in_progress' ? 'In Progress' : ($task->status === 'completed' ? 'Completed' : 'Cancelled')) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Project --}}
    <div class="flex items-center gap-2 text-sm text-text-secondary mb-2">
        <x-dynamic-component 
                :component="'lucide-' . ($task->project->icon ?: 'folder')"
                class="w-4" 
            />
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
        <p class="text-sm text-text-secondary leading-relaxed line-clamp-3 font-montserrat">
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
                    @foreach($task->collaborators->take(3) as $user)
                        <img
                            src="{{ $user->avatar ?: '/images/profile.jpg' }}"
                            class="w-8 h-8 rounded-full border-2 border-white -ml-4 first:ml-0 object-cover"
                        >
                    @endforeach
                </div>
                <span class="text-sm font-semibold text-text-primary font-montserrat">
                    {{ $task->collaborators->count() }} / {{ $task->go_collab_limit }}
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
                    $days = now()->startOfDay()->diffInDays($task->deadline->startOfDay(), false);
                @endphp

                @if($days < -1)
                    <span class="text-red-500 font-semibold text-sm">
                        Overdue by {{ $days * -1 }} days
                    </span>
                @elseif($days == -1)
                    <span class="text-red-500 font-semibold text-sm">
                        Overdue yesterday
                    </span>
                @elseif($days == 0)
                    <span class="text-yellow-500 font-semibold text-sm">
                        Due Today
                    </span>
                @elseif($days > 1)
                    <span class="text-text-primary font-semibold text-sm">
                        {{ $days }} days left
                    </span>
                @else
                    <span class="text-text-primary font-semibold text-sm">
                        {{ $days }} day left
                    </span>
                @endif
            @else
                <span class="text-text-secondary text-sm">
                    No deadline
                </span>
            @endif
        </div>
    </div>

    {{-- Buttons --}}
    <div class="mt-5 font-montserrat">

        {{-- View Details --}}
        <button
            @click="open({
                id: {{ $task->id }},
                title: @js($task->title),
                description: @js($task->description),
                image: @js($task->image),
                priority: @js($task->priority),
                status: @js($task->status),
                deadline: @js(optional($task->deadline)?->format('d M Y')),
                project: @js($task->project->title),
                project_icon: @js($task->project->icon),
                leader: @js($task->project->leader->name),
                leader_avatar: @js($task->project->leader->avatar),
                go_collab_description: @js($task->go_collab_description),
                go_collab_reward: {{ $task->go_collab_reward }},
                go_collab_limit: {{ $task->go_collab_limit }},
                collaborators: @js(
                    $task->collaborators->map(fn($user)=>[
                        'id'=>$user->id,
                        'name'=>$user->name,
                        'avatar'=>$user->avatar,
                        'status'=>$user->pivot->status,
                    ])
                ),
                isLeader: @js($isLeader),
                isCollaborator: @js($isCollaborator),
                submission: @js(
                    $submission ? [
                        'id' => $submission->id,
                        'task_id' => $task->id,
                        'title' => $task->title,
                        'submitter' => $submission->submitter->name,
                        'submitter_avatar' => $submission->submitter->avatar,
                        'submitted_at' => optional($submission->created_at)?->format('d M Y'),
                        'proof_image' => $submission->proof_image,
                        'proof_link' => $submission->proof_link,
                        'notes' => $submission->notes,
                        'status' => $submission->status,
                    ] : null
                ),
            })"
            class="w-full py-2.5 rounded-full border-2 border-gray-100 shadow-sm
                   text-sm font-semibold text-text-primary hover:bg-surface
                   transition-colors flex justify-center items-center gap-2 cursor-pointer">

            View Details
            <x-lucide-eye class="w-4 h-4"/>

        </button>

        {{-- Review / View Submission / Submit --}}
        @if($submission)

            @if($isLeader && $submission->status === 'pending')

                <button
                    @click="openReview({
                        id: {{ $submission->id }},
                        task_id: {{ $task->id }},
                        title: @js($task->title),
                        submitter: @js($submission->submitter->name),
                        submitter_avatar: @js($submission->submitter->avatar),
                        submitted_at: @js($submission->created_at?->format('d M Y')),
                        proof_image: @js($submission->proof_image),
                        proof_link: @js($submission->proof_link),
                        notes: @js($submission->notes),
                        status: @js($submission->status),
                    })"
                    class="w-full mt-3 py-2.5 rounded-full bg-review-submission
                           hover:bg-review-submission/60 transition-colors
                           text-sm font-semibold text-text-primary flex
                           justify-center items-center gap-2 cursor-pointer">

                    Review Submission
                    <x-lucide-search-check class="w-4 h-4"/>

                </button>

            @else

                <button
                    @click="openSubmission({
                        id: {{ $submission->id }},
                        task_id: {{ $task->id }},
                        title: @js($task->title),
                        submitter: @js($submission->submitter->name),
                        submitter_avatar: @js($submission->submitter->avatar),
                        submitted_at: @js($submission->created_at?->format('d M Y')),
                        proof_image: @js($submission->proof_image),
                        proof_link: @js($submission->proof_link),
                        notes: @js($submission->notes),
                        status: @js($submission->status),
                    })"
                    class="w-full mt-3 py-2.5 rounded-full bg-mark-completed
                           hover:bg-mark-completed/60 transition-colors
                           text-sm font-semibold text-text-primary flex
                           justify-center items-center gap-2 cursor-pointer">

                    View Submission
                    <x-lucide-view class="w-4 h-4"/>

                </button>

            @endif

        @elseif($isCollaborator && $task->status !== 'completed' && $task->status !== 'cancelled')

            <button
                @click="openComplete({
                    id: {{ $task->id }},
                    title: @js($task->title),
                    description: @js($task->description),
                    go_collab_reward: @js($task->go_collab_reward)
                })"
                class="w-full mt-3 py-2.5 rounded-full bg-mark-completed
                    hover:bg-mark-completed/60 transition-colors
                    text-sm font-semibold text-text-primary flex
                    justify-center items-center gap-2 cursor-pointer">

                Mark as Completed
                <x-lucide-check-circle class="w-4 h-4"/>

            </button>

        @endif

    </div>

</div>