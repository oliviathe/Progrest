@extends('layouts.task') 

@section('title', 'Project - ' . $project->title)

@section('content')

    {{-- PROJECT HEADER --}}
    <div class="bg-primary rounded-b-[2.5rem] shadow-lg overflow-hidden">
        <div class="px-7 py-8">

            {{-- Bagian atas --}}
            <div class="flex flex-col lg:flex-row justify-center items-center gap-8">

                {{-- Kiri --}}
                <div class="flex gap-6 flex-1">

                    {{-- Project Icon --}}
                    <div class="w-12 h-12 rounded-2xl bg-white/20 border border-white/10 flex items-center justify-center shrink-0">
                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center">

                            <x-dynamic-component
                                :component="'lucide-' . $project->icon"
                                class="w-8 h-8 text-white"
                            />
                        </div>
                    </div>

                    {{-- Project Info --}}
                    <div class="flex flex-col justify-center">
                        <h1 class="font-montserrat text-3xl font-bold text-white leading-none">
                            {{ $project->title }}
                        </h1>
                        <p class="mt-2 max-w-xl text-white/70 font-montserrat text-md leading-relaxed">
                            {{ $project->description }}
                        </p>
                    </div>
                </div>

                {{-- Bagian kanan --}}
                <div class="flex flex-col sm:flex-row gap-4 items-start">

                    {{-- Search --}}
                    <form method="GET" class="relative">
                        <input
                            type="hidden"
                            name="sort"
                            value="{{ request('sort','recent') }}"
                        >
                        <input
                            type="hidden"
                            name="direction"
                            value="{{ request('direction','desc') }}"
                        >
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none z-10">
                            <x-lucide-search class="w-5 h-5 text-white"/>
                        </div>
                        <input
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search task..."
                            onchange="this.form.submit()"
                            class="w-80
                                rounded-xl
                                bg-white/10
                                border border-white/10
                                backdrop-blur-md
                                text-white
                                placeholder:text-white/60
                                py-2.5
                                pl-12
                                pr-2
                                outline-none
                                font-montserrat"
                        >
                    </form>

                    {{-- Button --}}
                    <button
                        onclick="openPanel()"
                        @click="showCreateModal = true"
                        class="flex items-center gap-3
                            bg-quartiary
                            hover:bg-quartiary-hover
                            rounded-2xl
                            px-4
                            py-2.5
                            text-white
                            font-semibold
                            cursor-pointer
                            transition">

                        <div
                            class="w-6 h-6 rounded-full
                                bg-primary
                                flex items-center justify-center">

                            <x-lucide-plus class="w-5"/>
                        </div>
                        Create Task
                    </button>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-white/20 mt-4 pt-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 justify-items-center">

                    {{-- Project LEader --}}
                    <div class="relative">
                        <p class="text-white/80 uppercase tracking-wider font-montserrat text-xs">
                            Project Leader
                        </p>
                        <div class="flex items-center mt-4">
                            <div
                                class="w-12 h-12 rounded-full
                                    bg-yellow-400/20
                                    flex items-center justify-center
                                    mr-4 absolute">
                                <x-lucide-crown
                                    class="w-6 text-yellow-300"/>
                            </div>

                            <img
                                src="{{ $project->leader->avatar ? $project->leader->avatar : '/images/profile.jpg' }}"
                                class="ml-9 w-10 h-10 rounded-full object-cover border-2 border-white"
                            >

                            <div class="ml-4">
                                <h4 class="text-white font-semibold">
                                    {{ $project->leader->name }}
                                </h4>
                                <span class="text-white/60 text-sm">
                                    Project Leader
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- MEMBERS --}}
                    <div>
                        <p class="text-white/80 uppercase tracking-wider text-xs font-montserrat">
                            Members
                        </p>
                        <div class="flex items-center mt-4">
                            <div class="flex -space-x-4">
                                @foreach(array_slice($teamMembers,0,$displayLimit) as $avatar)
                                    <img
                                        src="{{ $avatar }}"
                                        class="w-10 h-10 rounded-full border-2 border-primary object-cover">
                                @endforeach

                                @if($extraMembers)
                                    <div
                                        class="w-10 h-10 rounded-full bg-white
                                            flex items-center justify-center
                                            font-bold">
                                        +{{ $extraMembers }}
                                    </div>
                                @endif
                            </div>

                            <span class="ml-4 text-white/50 text-sm">
                                {{ count($teamMembers) }} Members
                            </span>
                        </div>
                    </div>

                    {{-- PROGRESS --}}
                    <div>
                        <p class="text-white/80 uppercase tracking-wider text-xs font-montserrat">
                            Progress
                        </p>
                        <div class="flex items-center mt-4">

                            {{-- Circular progress indicator completed tasks --}}
                            <div
                                class="w-14 h-14 rounded-full flex items-center justify-center"
                                style="
                                    background:
                                    conic-gradient(
                                        #4ADE80 {{ $progress }}%,
                                        rgba(255,255,255,.2) 0
                                    );
                                "
                            >
                                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center">
                                    <span class="text-xs text-white">
                                        {{ round($progress) }}%
                                    </span>
                                </div>
                            </div>
                            <div class="ml-5">
                                <h4 class="text-white text-2xl font-bold font-montserrat">
                                    {{ $completedTasks }}
                                    /
                                    {{ $totalTasks }}
                                </h4>
                                <p class="text-white/60 text-sm">
                                    Tasks Completed
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- DEADLINE --}}
                    <div>
                        <p class="text-white/80 uppercase tracking-wider text-xs font-montserrat">
                            Due Date
                        </p>
                        <div class="flex items-center mt-4">
                            <div
                                class="w-10 h-10 rounded-xl
                                    bg-white/10
                                    flex items-center justify-center">

                                <x-lucide-calendar
                                    class="w-5 text-green-300"/>
                            </div>
                            <div class="ml-4">
                                @if (!is_null($project->deadline))
                                    <h4 class="text-white text-lg font-semibold font-montserrat">
                                        {{ $project->deadline->format('d M Y') }}
                                    </h4>
                                @else
                                    <h4 class="text-white text-lg font-semibold font-montserrat">
                                        Deadline Not Set
                                    </h4>
                                @endif
                                @if (!is_null($project->deadline))
                                    @if ($project->days_remaining < 0)
                                        <p class="text-red-accent font-semibold font-montserrat text-sm">
                                            {{ $project->days_remaining * -1 }}
                                            days overdue
                                        </p>
                                    @elseif ($project->days_remaining > 0)
                                        <p class="text-white/80 font-montserrat text-sm">
                                            {{ $project->days_remaining }}
                                            days remaining
                                        </p>
                                    @else
                                        <p class="text-yellow-300 font-montserrat text-sm">
                                            Due Today
                                        </p>
                                    @endif
                                @else
                                    <p class="text-white/80 font-montserrat text-sm">
                                        {{ $project->days_remaining }}
                                        ---
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PRIORITY TASKS --}}
    @if ($priorityTasks->isNotEmpty())
        <div x-data="{showTaskModal:false, showCreateModal:false}" class="p-8 py-6">
            <h1 class="font-montserrat text-text-primary text-2xl font-bold">Top Priorities</h1>
            
            <div class="flex flex-nowrap overflow-x-auto gap-5 pt-4 pb-4">
                @foreach ($priorityTasks as $task)
                    <div class="shrink-0 w-70 sm:w-[320px]">
                        @include('projects.tasks.priority-card', [
                            'status' => $task['status'],
                            'title' => $task['title'],
                            'dueDate' => $task['deadline'],
                            'daysLeft' => floor(now()->diffInDays($task->deadline, false)),
                            'priority' => $task['priority']
                        ])
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="py-3"></div>
    @endif


    {{-- TASKS LIST --}}
    @if ($allTasks->isNotEmpty())
        <div class="px-8 pb-10" 
            x-data="taskModal()">
            <div class="flex flex-col sm:flex-row justify-between items-center">
                <h1 class="font-montserrat text-text-primary text-2xl font-bold mb-3 sm:mb-0">All Tasks</h1>
                
                <div class="flex gap-4">

                    {{-- SORT BUTTON --}}

                    <form method="GET" class="flex gap-3">

                        {{-- Preserve current direction when changing sort --}}
                        <input
                            id="directionInput"
                            type="hidden"
                            name="direction"
                            value="{{ request('direction', 'desc') }}"
                        >

                        {{-- Direction Toggle --}}
                        <button
                            type="submit"
                            name="direction"
                            value="{{ request('direction', 'desc') === 'asc' ? 'desc' : 'asc' }}"
                            onclick="document.getElementById('directionInput').disabled = true"
                            class="bg-background rounded-2xl p-2 shadow-sm hover:bg-surface transition-colors"
                        >
                            <x-lucide-arrow-up-down class="w-5 h-5 text-text-primary" />
                        </button>

                        {{-- Sort Dropdown --}}
                        <select
                            name="sort"
                            onchange="this.form.submit()"
                            class="bg-background rounded-3xl px-3 shadow-sm font-montserrat text-sm text-text-primary hover:bg-surface transition-colors focus:outline-none"
                        >
                            <option value="priority" {{ request('sort', 'priority') == 'priority' ? 'selected' : '' }}>
                                Priority
                            </option>

                            <option value="alphabetical" {{ request('sort') == 'alphabetical' ? 'selected' : '' }}>
                                Alphabetical
                            </option>

                            <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>
                                Deadline
                            </option>
                        </select>

                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                @foreach ($allTasks as $task)
                    @include('projects.tasks.card', [
                        'project' => $project,
                        'task' => $task,
                    ]) 
                @endforeach
            </div>

            {{-- Task Detail Modal --}}
            <div
                x-show="show"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-6"
            >

                <div
                    @click.outside="close()"
                    class="bg-background rounded-3xl shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden"
                >

                    {{-- HEADER --}}
                    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 shrink-0">

                        <div class="flex items-center gap-3">

                            <div class="w-12 h-12 rounded-2xl bg-surface flex items-center justify-center">
                                <x-lucide-clipboard-list class="w-6 h-6 text-primary"/>
                            </div>

                            <div>

                                <h1 class="font-montserrat text-2xl font-bold text-text-primary">
                                    Task Details
                                </h1>

                                <p class="text-text-secondary text-sm">
                                    View task information
                                </p>

                            </div>

                        </div>

                        <button
                            @click="close()"
                            class="w-10 h-10 rounded-full hover:bg-surface transition flex items-center justify-center"
                        >
                            <x-lucide-x class="w-5 h-5"/>
                        </button>

                    </div>

                    {{-- BODY --}}
                    <div class="flex-1 overflow-y-auto px-6 py-5 space-y-5">

                        {{-- Title --}}
                        <div>

                            <p class="text-sm font-semibold mb-2">
                                Task Title
                            </p>

                            <div class="bg-surface rounded-2xl px-5 py-3">

                                <p
                                    class="font-montserrat text-lg"
                                    x-text="task.title"
                                ></p>

                            </div>

                        </div>

                        {{-- Description --}}
                        <div>

                            <p class="text-sm font-semibold mb-2">
                                Description
                            </p>

                            <div class="bg-surface rounded-2xl px-5 py-4">

                                <p
                                    class="text-text-secondary whitespace-pre-line leading-7"
                                    x-text="task.description"
                                ></p>

                            </div>

                        </div>

                        {{-- GRID --}}
                        <div class="grid grid-cols-2 gap-5">

                            {{-- Collaborator --}}
                            <div>

                                <p class="text-sm font-semibold mb-2">
                                    Collaborator
                                </p>

                                <div class="bg-surface rounded-2xl px-4 py-3 flex items-center gap-3">

                                    <img
                                        src="/images/profile.jpg"
                                        class="w-10 h-10 rounded-full"
                                    >

                                    <span class="font-medium">
                                        Kevin
                                    </span>

                                </div>

                            </div>

                            {{-- Status --}}
                            <div>

                                <p class="text-sm font-semibold mb-2">
                                    Status
                                </p>

                                <div class="bg-surface rounded-2xl px-4 py-3">

                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-pastel-yellow-background text-pastel-yellow-text font-semibold text-sm"
                                    >

                                        <div class="w-2 h-2 rounded-full bg-pastel-yellow-text"></div>

                                        <span
                                            x-text="task.completed ? 'Completed' : 'In Progress'"
                                        ></span>

                                    </span>

                                </div>

                            </div>

                            {{-- Deadline --}}
                            <div>

                                <p class="text-sm font-semibold mb-2">
                                    Deadline
                                </p>

                                <div class="bg-surface rounded-2xl px-4 py-3 flex items-center gap-3">

                                    <x-lucide-calendar class="w-5 h-5 text-text-secondary"/>

                                    <span x-text="task.deadline"></span>

                                </div>

                            </div>

                            {{-- Priority --}}
                            <div>

                                <p class="text-sm font-semibold mb-2">
                                    Priority
                                </p>

                                <div class="bg-surface rounded-2xl px-4 py-3">

                                    <span
                                        class="px-3 py-1 rounded-full text-white font-semibold"
                                        :class="{
                                            'bg-red-accent': task.priority == 'high',
                                            'bg-yellow-accent': task.priority == 'medium',
                                            'bg-quartiary': task.priority == 'low'
                                        }"
                                        x-text="task.priority"
                                    ></span>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="border-t border-gray-100 px-6 py-4 flex justify-end gap-3 shrink-0">

                        <button
                            class="bg-primary text-white px-5 py-2.5 rounded-2xl hover:bg-primary-hover transition"
                        >
                            Go to Collaboration
                        </button>

                        <button
                            @click="close()"
                            class="border border-gray-200 px-5 py-2.5 rounded-2xl hover:bg-surface transition"
                        >
                            Close
                        </button>

                    </div>

                </div>

            </div>
        </div>
    @endif
@endsection 