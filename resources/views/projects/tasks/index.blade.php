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
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 shadow-2xl backdrop-blur-sm p-6"
            >

                {{-- Aksen Hijau  --}}
                <div class="absolute -top-24 left-3/4
                    h-64 w-86 -translate-x-1/2
                    rounded-full bg-emerald-300/15
                    blur-3xl">
                </div>

                <div
                    @click.outside="close()"
                    class="bg-background rounded-3xl shadow-xl w-full max-w-xl max-h-[90vh] flex flex-col overflow-hidden"
                >

                    {{-- HEADER --}}
                    <div class="flex items-center justify-between px-6 py-5 border-b-2 border-border shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="flex justify-center items-center w-10 h-10 border-pastel-green-text bg-pastel-green-background border-2 p-2 rounded-2xl shadow-3xl shadow-[0_10px_30px_rgba(0,0,0,0.12)]">
                                <x-lucide-folder-bookmark class="w-6 text-pastel-green-text"/>
                            </div>
                            <div>
                                <h1 class="font-montserrat text-2xl font-bold text-text-primary"
                                    x-text="editing ? 'Edit Task' : 'Task Detail'">
                                </h1>
                                <p class="text-text-secondary text-sm"
                                    x-text="editing ? 'Update task information' : 'View task information'">
                                </p>
                            </div>
                        </div>

                        <button
                            @click="close()"
                            class="w-12 h-12 rounded-full hover:bg-surface flex items-center justify-center hover:rotate-90 rotate-0 transition duration-300 cursor-pointer"
                        >
                            <x-lucide-x class="w-5 h-5 text-text-primary"/>
                        </button>
                    </div>

                    {{-- BODY --}}
                    <div class="flex-1 overflow-y-auto px-6 py-5 space-y-5">

                        {{-- Task Image --}}

                        <div class="space-y-2">
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                Task Image
                            </p>

                            <template x-if="!editing">
                                <div class="rounded-2xl overflow-hidden border-2 border-border bg-background w-50">
                                    <img
                                        :src="
                                            task.image_preview
                                                ? task.image_preview
                                                : (
                                                    task.image && task.image.startsWith('/images/')
                                                        ? task.image
                                                        : '/storage/' + task.image
                                                )
                                        "
                                        class="w-full h-24 object-cover"
                                    >
                                </div>
                            </template>

                            <template x-if="editing">
                                <div class="rounded-2xl border-2 border-dashed border-border bg-background p-4">
                                    <div class="flex items-center gap-5">
                                        <img
                                            :src="
                                                task.image_preview
                                                    ? task.image_preview
                                                    : (
                                                        task.image && task.image.startsWith('/images/')
                                                            ? task.image
                                                            : '/storage/' + task.image
                                                    )
                                            "
                                            class="w-40 h-28 rounded-xl object-cover border border-border shrink-0"
                                        >

                                        <div class="flex flex-col justify-center gap-3 flex-1 font-montserrat">

                                            <div>
                                                <p class="font-semibold text-md text-text-primary">
                                                    Replace Image
                                                </p>

                                                <p class="text-sm text-text-secondary mt-1">
                                                    Upload a new image for this task.
                                                </p>
                                            </div>

                                            <label
                                                class="inline-flex w-fit items-center gap-2
                                                    rounded-xl bg-primary px-4 py-2
                                                    text-sm font-medium text-white
                                                    cursor-pointer hover:bg-primary-hover transition"
                                            >
                                                <x-lucide-upload class="w-4 h-4"/>

                                                <span>Choose Image</span>

                                                <input
                                                    type="file"
                                                    accept="image/*"
                                                    @change="previewTaskImage($event)"
                                                    class="hidden"
                                                >
                                            </label>

                                            <p class="text-[11px] text-text-secondary">
                                                JPG, PNG or WebP • Max 4 MB
                                            </p>

                                        </div>

                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- Title --}}
                        <div>
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                Task Title
                            </p>
                            <div class="bg-surface rounded-xl px-5 py-2 mt-1">
                                <template x-if="!editing">
                                    <p class="font-montserrat text-sm text-text-primary"
                                        x-text="task.title"
                                    ></p>
                                </template>
                                <template x-if="editing">
                                    <input type="text" x-model="task.title"
                                        class="w-full bg-transparent outline-none text-sm font-montserrat text-text-primary"
                                    >
                                </template>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                Description
                            </p>
                            <div class="bg-surface rounded-xl px-5 py-3 mt-1">
                                <template x-if="!editing"> 
                                    <p
                                        class="font-montserrat text-sm text-text-primary whitespace-pre-line leading-7"
                                        x-text="task.description"
                                    ></p>
                                </template>
                                <template x-if="editing"> 
                                    <textarea
                                        x-model="task.description"
                                        x-init="$nextTick(() => {
                                            $el.style.height = '0px';
                                            $el.style.height = $el.scrollHeight + 'px';
                                        })"
                                        @input="
                                            $el.style.height = '0px';
                                            $el.style.height = $el.scrollHeight + 'px';
                                        "
                                        class="w-full bg-transparent resize-none overflow-hidden outline-none text-sm font-montserrat text-text-primary"
                                    ></textarea>
                                </template>
                            </div>
                        </div>

                        {{-- GRID --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            {{-- Collaborator --}}
                                <div>
                                    <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                        Collaborators
                                    </p>

                                    <template x-if="!editing">
                                        <div
                                            class="mt-1 bg-surface rounded-2xl px-4 py-3"
                                            x-data="{ showMembers: false }"
                                        >
                                            {{-- Top Row --}}
                                            <div class="flex items-center justify-between pl-2">
                                                {{-- Tumpukan avatar --}}
                                                <div class="flex items-center">
                                                    {{-- Mobile --}}
                                                    <div class="flex lg:hidden">
                                                        <template x-for="member in (task.members ?? []).slice(0,3)" :key="member.id">
                                                            <img
                                                                :src="member.avatar ? member.avatar : '/images/profile.jpg'"
                                                                class="w-8 h-8 shrink-0 min-w-8 rounded-full object-cover border-2 border-surface first:ml-1 -ml-2.5"
                                                            >
                                                        </template>
                                                        <template x-if="(task.members || []).length > 3">
                                                            <div
                                                                class="w-8 h-8 rounded-full bg-background border-2 border-surface flex items-center justify-center text-xs font-semibold -ml-2.5"
                                                            >
                                                                <span x-text="'+' + ((task.members || []).length - 3)"></span>
                                                            </div>
                                                        </template>
                                                    </div>

                                                    {{-- Desktop --}}
                                                    <div class="hidden lg:flex">
                                                        <template x-for="member in (task.members ?? []).slice(0,5)" :key="member.id">
                                                            <img
                                                                :src="member.avatar ? member.avatar : '/images/profile.jpg'"
                                                                class="w-8 h-8 min-w-8 shrink-0 rounded-full object-cover border-2 border-surface first:ml-0 -ml-2.5"
                                                            >
                                                        </template>

                                                        <template x-if="(task.members || []).length > 5">
                                                            <div
                                                                class="w-8 h-8 rounded-full bg-background border-2 border-surface flex items-center justify-center text-xs font-semibold -ml-2.5"
                                                            >
                                                                <span x-text="'+' + ((task.members || []).length - 5)"></span>
                                                            </div>
                                                        </template>
                                                    </div>

                                                </div>

                                                {{-- Expand Button --}}
                                                <button
                                                    @click="showMembers = !showMembers"
                                                    class="flex items-center gap-1 text-hyperlink hover:opacity-80 transition text-sm font-medium"
                                                >
                                                    <span
                                                        class="cursor-pointer font-montserrat"
                                                        x-text="showMembers
                                                            ? 'Hide'
                                                            : `View all (${(task.members || []).length})`">
                                                    </span>

                                                    <x-lucide-chevron-down
                                                        class="w-4 h-4 transition-transform duration-200"
                                                        ::class="{ 'rotate-180': showMembers }"
                                                    />
                                                </button>

                                            </div>

                                            {{-- Expandable members (view all members) --}}
                                            <div
                                                x-show="showMembers"
                                                x-collapse
                                                class="mt-4 border-t-2 border-border pt-3"
                                            >
                                                <div class="max-h-56 overflow-y-auto space-y-2 pr-1"
                                                >
                                                    <template
                                                        x-for="member in task.members"
                                                        :key="member.id"
                                                    >
                                                        <div class="flex items-center justify-between rounded-xl px-3 py-2 hover:bg-background transition"
                                                        >
                                                            <div class="flex items-center gap-3">
                                                                <img
                                                                    :src="member.avatar ? member.avatar : '/images/profile.jpg'"
                                                                    class="w-6 h-6 min-w-6 shrink-0 rounded-full object-cover"
                                                                >
                                                                <div>
                                                                    <p
                                                                        class="font-montserrat text-sm font-semibold text-text-primary"
                                                                        x-text="member.name"
                                                                    ></p>

                                                                    <p
                                                                        x-show="member.id == task.leader_id"
                                                                        class="text-xs text-emerald-600"
                                                                    >
                                                                        Project Leader
                                                                    </p>

                                                                </div>

                                                            </div>

                                                            <x-lucide-crown
                                                                x-show="member.id == task.leader_id"
                                                                class="w-4 h-4 text-yellow-500"
                                                            />

                                                        </div>

                                                    </template>

                                                </div>

                                            </div>

                                        </div>
                                    </template>

                                    <template x-if="editing">
                                        <div
                                            class="bg-surface rounded-2xl p-4 space-y-4"
                                        >
                                            {{-- Header --}}
                                            <div class="flex items-center gap-2">
                                                <div class="shadow-2xl shadow-pastel-blue-background">
                                                    <x-lucide-users class="w-5 text-primary"/>
                                                </div>

                                                <div>
                                                    <p class="font-montserrat text-sm font-semibold text-text-primary">
                                                        Collaborators
                                                    </p>

                                                    <p class="text-xs text-text-secondary font-montserrat">
                                                        Add or remove members assigned to this task.
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- Search --}}
                                            <div class="space-y-1">

                                                <p class="text-xs font-semibold text-text-primary font-montserrat">
                                                    Search users
                                                </p>

                                                <div class="relative">

                                                    <x-lucide-search
                                                        class="absolute left-4 top-1/2 -translate-y-1/2
                                                            w-4 h-4 text-text-secondary"
                                                    />

                                                    <input
                                                        type="text"
                                                        x-model="assignedMemberQuery"
                                                        @input="searchAssignedMembers()"
                                                        placeholder="Username or email..."
                                                        class="w-full rounded-xl
                                                            border-2 border-border
                                                            bg-background
                                                            py-2.5 pl-11 pr-10
                                                            text-[12px]
                                                            text-text-primary
                                                            outline-none
                                                            focus:border-primary font-montserrat"
                                                    >

                                                    <button
                                                        x-show="assignedMemberQuery.length"
                                                        @click="
                                                            assignedMemberQuery = '';
                                                            assignedSearchResults = [];
                                                        "
                                                        type="button"
                                                        class="absolute right-3 top-1/2
                                                            -translate-y-1/2
                                                            rounded-full p-1
                                                            hover:bg-surface cursor-pointer"
                                                    >
                                                        <x-lucide-x class="w-4 h-4 text-text-primary"/>
                                                    </button>

                                                    {{-- Dropdown --}}
                                                    <div
                                                        x-show="assignedSearchResults.length"
                                                        x-transition
                                                        class="absolute left-0 right-0 top-full mt-2
                                                            rounded-xl border border-border
                                                            bg-background
                                                            shadow-xl
                                                            overflow-hidden
                                                            z-50"
                                                    >

                                                        <template
                                                            x-for="user in assignedSearchResults"
                                                            :key="user.id"
                                                        >

                                                            <button
                                                                type="button"
                                                                @click="addAssignedMember(user)"
                                                                class="w-full
                                                                    flex items-center gap-2
                                                                    px-2 py-3
                                                                    hover:bg-surface
                                                                    transition"
                                                            >

                                                                <img
                                                                    :src="user.avatar || '/images/profile.jpg'"
                                                                    class="w-6 h-6 rounded-full object-cover"
                                                                >

                                                                <div class="flex flex-col text-left">

                                                                    <span
                                                                        class="font-semibold text-sm text-text-primary font-montserrat"
                                                                        x-text="user.name"
                                                                    ></span>

                                                                    <span
                                                                        class="text-[10px] text-text-secondary font-montserrat"
                                                                        x-text="user.email"
                                                                    ></span>

                                                                </div>

                                                            </button>

                                                        </template>

                                                    </div>

                                                </div>

                                            </div>

                                            {{-- Selected members --}}
                                            <div class="space-y-2">

                                                <p class="text-xs font-semibold text-text-primary">
                                                    Assigned Members
                                                </p>

                                                <template
                                                    x-for="member in assignedMembers"
                                                    :key="member.id"
                                                >

                                                    <div
                                                        class="flex items-center justify-between
                                                            rounded-xl
                                                            bg-background
                                                            px-3 py-2
                                                            border border-border"
                                                    >

                                                        <div class="flex items-center gap-3">

                                                            <img
                                                                :src="member.avatar || '/images/profile.jpg'"
                                                                class="w-9 h-9 rounded-full object-cover"
                                                            >

                                                            <div>

                                                                <p
                                                                    class="font-medium text-sm text-text-primary"
                                                                    x-text="member.name"
                                                                ></p>

                                                                <p
                                                                    x-show="member.id == task.leader_id"
                                                                    class="text-xs text-emerald-600"
                                                                >
                                                                    Project Leader
                                                                </p>

                                                            </div>

                                                        </div>

                                                        <button
                                                            type="button"
                                                            @click="removeAssignedMember(member.id)"
                                                            class="w-8 h-8
                                                                rounded-full
                                                                hover:bg-red-50
                                                                text-red-500
                                                                transition"
                                                        >
                                                            <x-lucide-x class="w-4 h-4 mx-auto"/>
                                                        </button>

                                                    </div>

                                                </template>

                                            </div>

                                        </div>

                                    </template>
                                </div>

                            {{-- Status --}}
                            <div>
                                <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                    Status
                                </p>
                                <div class="bg-surface rounded-2xl px-4 py-3 mt-1">
                                    <!-- View -->
                                    <template x-if="!editing">
                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full font-semibold text-sm"
                                            :class="{
                                                'bg-blue-100 text-blue-700': task.status === 'pending',
                                                'bg-orange-100 text-orange-700': task.status === 'in_progress',
                                                'bg-green-100 text-green-700': task.status === 'completed',
                                                'bg-red-100 text-red-700': task.status === 'cancelled'
                                            }"
                                        >
                                            <div class="w-2 h-2 rounded-full"
                                                :class="{
                                                    'bg-blue-700': task.status === 'pending',
                                                    'bg-orange-700': task.status === 'in_progress',
                                                    'bg-green-700': task.status === 'completed',
                                                    'bg-red-700': task.status === 'cancelled'
                                                }"    
                                            ></div>
                                            <span
                                                x-text="task.status === 'completed'
                                                    ? 'Completed'
                                                    : (task.status === 'in_progress'
                                                        ? 'In Progress'
                                                        : (task.status === 'pending'
                                                            ? 'Pending'
                                                            : 'Cancelled'))"
                                            ></span>
                                        </span>
                                    </template>

                                    <!-- Edit -->
                                    <div x-show="editing" class="grid grid-cols-2 gap-2 mt-1">
                                        <button
                                            @click="task.status='pending'"
                                            :class="task.status == 'pending'
                                                ? 'bg-blue-accent text-white'
                                                : 'bg-surface text-text-primary border-2 border-border'"
                                            class="rounded-xl py-2 transition font-montserrat text-[12px] cursor-pointer"
                                        >
                                            Pending
                                        </button>
                                        <button
                                            @click="task.status='in_progress'"
                                            :class="task.status == 'in_progress'
                                                ? 'bg-yellow-accent text-white'
                                                : 'bg-surface text-text-primary border-2 border-border'"
                                            class="rounded-xl py-2 transition font-montserrat text-[12px] cursor-pointer"
                                        >
                                            In Progress
                                        </button>
                                        <button
                                            @click="task.status='completed'"
                                            :class="task.status == 'completed'
                                                ? 'bg-quartiary text-white'
                                                : 'bg-surface text-text-primary border-2 border-border'"
                                            class="rounded-xl py-2 transition font-montserrat text-[12px] cursor-pointer"
                                        >
                                            Completed
                                        </button>
                                        <button
                                            @click="task.status='cancelled'"
                                            :class="task.status == 'cancelled'
                                                ? 'bg-red-accent text-white'
                                                : 'bg-surface text-text-primary border-2 border-border'"
                                            class="rounded-xl py-2 transition font-montserrat text-[12px] cursor-pointer"
                                        >
                                            Cancelled
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Deadline --}}
                            <div>
                                <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                    Deadline
                                </p>
                                <template x-if="!editing">
                                    <div class="bg-surface rounded-2xl px-4 py-3 mt-1">
                                        <div class="flex items-center gap-3">
                                            <x-lucide-calendar class="w-4.5 h-4.5 text-text-secondary"/>
                                            <span
                                                class="text-sm text-text-primary font-montserrat"
                                                x-text="task.deadline"
                                            ></span>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="editing">
                                    <div class="relative">
                                        {{-- Custom icon --}}
                                        <x-lucide-calendar
                                            class="absolute right-4 top-1/2 -translate-y-1/2
                                                w-4.5 h-4.5 text-text-secondary pointer-events-none z-10"
                                        />
                                        <input
                                            type="date"
                                            x-model="task.deadline"
                                            class="date-input w-full rounded-xl
                                                border-2 border-border
                                                bg-background
                                                px-4 py-2 pr-12
                                                text-sm text-text-primary
                                                outline-none
                                                focus:ring-2 focus:ring-primary
                                                focus:border-primary z-0"
                                        >
                                    </div>
                                </template>
                            </div>

                            {{-- Priority --}}
                            <div>
                                <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                    Priority
                                </p>
                                <template x-if="!editing">
                                    <div class="bg-surface rounded-2xl px-4 py-3 mt-1">
                                        <span
                                            class="px-3 py-1 rounded-full text-white text-sm font-semibold"
                                            :class="{
                                                'bg-red-accent': task.priority == 'high',
                                                'bg-yellow-accent': task.priority == 'medium',
                                                'bg-quartiary': task.priority == 'low'
                                            }"
                                            x-text="task.priority === 'high' ? 'High' : (task.priority === 'medium' ? 'Medium' : 'Low')"
                                        ></span>
                                    </div>
                                </template>
                                <template x-if="editing">
                                    <div class="grid grid-cols-3 gap-2 mt-1">

                                        <button
                                            type="button"
                                            @click="task.priority = 'high'"
                                            :class="task.priority === 'high'
                                                ? 'bg-red-accent text-white border-red-accent'
                                                : 'bg-background border-border text-text-primary'"
                                            class="rounded-xl border-2 py-1.75 text-[12px] transition cursor-pointer"
                                        >
                                            High
                                        </button>

                                        <button
                                            type="button"
                                            @click="task.priority = 'medium'"
                                            :class="task.priority === 'medium'
                                                ? 'bg-yellow-accent text-white border-yellow-accent'
                                                : 'bg-background border-border text-text-primary'"
                                            class="rounded-xl border-2 py-1.75 text-[12px] transition cursor-pointer"
                                        >
                                            Medium
                                        </button>

                                        <button
                                            type="button"
                                            @click="task.priority = 'low'"
                                            :class="task.priority === 'low'
                                                ? 'bg-quartiary text-white border-quartiary'
                                                : 'bg-background border-border text-text-primary'"
                                            class="rounded-xl border-2 py-1.75 text-[12px] transition cursor-pointer"
                                        >
                                            Low
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- GO COLLAB --}}
                        <div>
                            <p class="font-montserrat font-semibold text-[12px] text-text-primary">
                                Go Collaboration
                            </p>

                            <div
                                class="mt-1 bg-surface rounded-2xl px-4 py-3"
                            >
                                {{-- SUMMARY --}}
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center"
                                        >
                                            <x-lucide-users
                                                class="w-5 h-5 text-primary"
                                            />
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="font-montserrat text-sm font-semibold text-text-primary"
                                                >
                                                    Go Collaboration
                                                </span>
                                                <span
                                                    class="px-2 py-0.5 rounded-full text-xs font-semibold"
                                                    :class="task.go_collab_enabled
                                                        ? 'bg-green-100 text-green-700'
                                                        : 'bg-gray-200 text-gray-600'"
                                                    x-text="task.go_collab_enabled ? 'Enabled' : 'Disabled'"
                                                ></span>
                                            </div>
                                            <template x-if="task.go_collab_enabled">
                                                <p
                                                    class="text-xs text-text-secondary mt-0.5"
                                                    x-text="`${task.go_collab_reward} Credits • Max ${task.go_collab_limit} collaborators`"
                                                ></p>
                                            </template>
                                        </div>
                                    </div>

                                    {{-- Expand --}}
                                    <div class="flex items-center justify-between font-montserrat">

                                        <!-- Viewing -->
                                        <template x-if="!editing && task.go_collab_enabled">
                                            <button
                                                @click="showCollab = !showCollab"
                                                class="flex items-center gap-1 text-hyperlink text-sm font-medium cursor-pointer"
                                            >
                                                <span x-text="showCollab ? 'Hide' : 'View Details'"></span>

                                                <x-lucide-chevron-down
                                                    class="w-4 h-4 transition-transform"
                                                    ::class="{ 'rotate-180': showCollab }"
                                                />
                                            </button>
                                        </template>

                                        <!-- Editing -->
                                        <template x-if="editing">
                                            <div>
                                                <button
                                                    type="button"
                                                    @click="
                                                        if (Boolean(task.go_collab_enabled)) {
                                                            showDisableCollabWarning = true;
                                                        } else {
                                                            task.go_collab_enabled = true;
                                                            showCollab = true;
                                                        }
                                                    "
                                                    class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors cursor-pointer"
                                                    :class="task.go_collab_enabled
                                                        ? 'bg-primary'
                                                        : 'bg-gray-300 dark:bg-gray-600'"
                                                >
                                                    <span
                                                        class="inline-block h-5 w-5 rounded-full bg-white transition-transform"
                                                        :class="task.go_collab_enabled
                                                            ? 'translate-x-6'
                                                            : 'translate-x-1'"
                                                    ></span>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                {{-- DETAILS --}}
                                <div
                                    x-show="showCollab"
                                    x-collapse
                                    class="mt-5 border-t-2 border-border pt-4 space-y-5"
                                >
                                    {{-- Description --}}
                                    <div>
                                        <p
                                            class="font-montserrat font-semibold text-xs text-text-primary mb-2"
                                        >
                                            Description
                                        </p>
                                        <template x-if="!editing">
                                            <div
                                                class="rounded-xl bg-background px-4 py-3"
                                            >
                                                <p
                                                    class="text-sm text-text-primary font-montserrat whitespace-pre-line"
                                                    x-text="task.go_collab_description || 'No description provided.'"
                                                ></p>
                                            </div>
                                        </template>
                                        <template x-if="editing">
                                            <textarea
                                                x-model="task.go_collab_description"
                                                rows="3"
                                                class="w-full rounded-xl bg-background text-text-primary px-4 py-3 resize-none outline-none border-2 border-border focus:border-primary"
                                            ></textarea>
                                        </template>
                                    </div>

                                    {{-- GRID --}}
                                    <div class="grid md:grid-cols-2 gap-4">
                                        {{-- Reward --}}
                                        <div>
                                            <p
                                                class="font-montserrat font-semibold text-xs text-text-primary mb-2"
                                            >
                                                Credit Reward
                                            </p>
                                            <template x-if="!editing">
                                                <div class="bg-background rounded-xl px-4 py-3 text-text-primary">
                                                    <span
                                                        class="font-montserrat text-sm text-text-primary"
                                                        x-text="task.go_collab_reward
                                                            ? task.go_collab_reward + ' Credits'
                                                            : 'Undefined'"
                                                    ></span>
                                                </div>
                                            </template>
                                            <template x-if="editing">
                                                <input
                                                    type="number"
                                                    min="0"
                                                    x-model="task.go_collab_reward"
                                                    class="w-full rounded-xl border-2 border-border text-text-primary bg-background px-4 py-2.5 outline-none focus:border-primary"
                                                >
                                            </template>
                                        </div>

                                        {{-- Maximum Collaborators --}}
                                        <div>
                                            <p
                                                class="font-montserrat font-semibold text-xs text-text-primary mb-2"
                                            >
                                                Maximum Collaborators
                                            </p>
                                            <template x-if="!editing">
                                                <div class="bg-background rounded-xl px-4 py-3">
                                                    <span
                                                        class="font-montserrat text-sm text-text-primary"
                                                        x-text="task.go_collab_limit ?? 'Undefined'"
                                                    ></span>

                                                </div>

                                            </template>

                                            <template x-if="editing">

                                                <input
                                                    type="number"
                                                    min="1"
                                                    x-model="task.go_collab_limit"
                                                    class="w-full rounded-xl border-2 border-border text-text-primary bg-background px-4 py-2.5 outline-none focus:border-primary"
                                                >

                                            </template>

                                        </div>

                                    </div>

                                    {{-- Participants --}}
                                    <div>

                                        <div class="flex items-center justify-between mb-2">

                                            <p
                                                class="font-montserrat font-semibold text-xs text-text-primary"
                                            >
                                                Current Participants
                                            </p>

                                            <span
                                                class="text-xs text-text-secondary"
                                                x-text="task.go_collab_limit != null
                                                    ? `${task.members?.length ?? 0} / ${task.go_collab_limit}`
                                                    : ''"
                                                {{-- x-text="`${task.collaborators?.length ?? 0} / ${task.go_collab_limit}`" --}}
                                            ></span>
                                        </div>

                                        <div
                                            class="bg-background rounded-xl p-3 max-h-48 overflow-y-auto space-y-2"
                                        >
                                            <template
                                                x-for="user in task.collaborators"
                                                :key="user.id"
                                            >
                                                <div
                                                    class="flex items-center justify-between rounded-lg px-2 py-2 hover:bg-surface transition"
                                                >
                                                    <div class="flex items-center gap-3">
                                                        <img
                                                            :src="user.avatar || '/images/profile.jpg'"
                                                            class="w-8 h-8 rounded-full object-cover"
                                                        >
                                                        <div>
                                                            <p
                                                                class="text-sm font-semibold text-text-primary"
                                                                x-text="user.name"
                                                            ></p>
                                                            <p
                                                                class="text-xs text-text-secondary"
                                                                x-text="user.pivot.status === 'declined' ? 
                                                                    'Declined' : (user.pivot.status === 'completed' ? 
                                                                        'Completed' : 'In Progress')"
                                                            ></p>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center gap-2">
                                                        <!-- hadiah -->
                                                        <template x-if="!editing">
                                                            <span
                                                                class="text-xs font-semibold text-primary"
                                                                x-text="user.pivot.reward_earned + ' pts'"
                                                            ></span>
                                                        </template>

                                                        <!-- Hapus collaborator -->
                                                        <template x-if="editing">
                                                            <button
                                                                type="button"
                                                                @click="removeCollaborator(user.id)"
                                                                class="w-8 h-8 rounded-full hover:bg-red-50 dark:hover:bg-red-500/15
                                                                    flex items-center justify-center transition-colors"
                                                            >
                                                                <x-lucide-x class="w-4 h-4 text-red-500"/>
                                                            </button>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            <template
                                                x-if="!task.collaborators || task.collaborators.length === 0"
                                            >

                                                <p
                                                    class="text-sm text-center text-text-secondary font-montserrat py-2"
                                                >
                                                    No collaborators yet.
                                                </p>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <template x-if="!editing">
                            <button
                                type="button"
                                @click="
                                    showDeleteTaskWarning = true;
                                "
                                class="flex items-center justify-center gap-2
                                    rounded-xl
                                    px-5 py-3
                                    text-sm font-semibold
                                    text-pastel-red-text
                                    font-montserrat
                                    border-2 border-pastel-red-text
                                    hover:bg-surface
                                    transition
                                    w-full
                                    cursor-pointer"
                            >
                                <x-lucide-trash-2 class="w-4 h-4"/>

                                Delete Task
                            </button>
                        </template>

                    </div>

                    <template x-if="showDeleteTaskWarning">
                        <div
                            class="fixed inset-0 z-100 bg-black/40 flex items-center justify-center backdrop-blur-sm p-6"
                            @click="showDeleteTaskWarning = false"
                        >

                            <div
                                class="bg-background rounded-2xl p-6 max-w-md w-full shadow-xl"
                                @click.stop
                            >

                                <h3 class="text-lg font-semibold text-text-primary font-montserrat">
                                    Delete Task?
                                </h3>

                                <p
                                    class="mt-3 text-sm text-text-secondary leading-6 font-montserrat"
                                    x-text="`This task currently has ${(task.members ?? []).length} collaborator(s) assigned. Deleting this task will remove it from their workspace and all related progress will be lost. This action cannot be undone.`"
                                ></p>

                                <div class="flex justify-end gap-3 mt-6">

                                    <button
                                        type="button"
                                        @click="showDeleteTaskWarning = false"
                                        class="px-4 py-2 rounded-xl
                                            bg-background
                                            border-2 border-border
                                            text-sm text-text-primary
                                            font-montserrat
                                            hover:bg-surface
                                            cursor-pointer
                                            transition"
                                    >
                                        Cancel
                                    </button>

                                    <button
                                        type="button"
                                        @click="
                                            showDeleteTaskWarning = false;
                                            deleteTask();
                                        "
                                        class="px-4 py-2 rounded-xl
                                            bg-red-500
                                            text-white
                                            text-sm
                                            font-montserrat
                                            hover:bg-red-accent
                                            cursor-pointer
                                            transition"
                                    >
                                        Delete Permanently
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Disable Warning Modal --}}
                    <template x-if="showDisableCollabWarning">
                        <div
                            class="fixed inset-0 z-100 bg-black/40 flex items-center justify-center backdrop-blur-sm"
                            @click="showDisableCollabWarning = false"
                        >
                            <div
                                class="bg-background rounded-2xl p-6 max-w-md w-full shadow-xl"
                                @click.stop
                            >

                                <h3 class="text-lg font-semibold text-text-primary font-montserrat">
                                    Disable Go Collaboration?
                                </h3>

                                <p class="mt-3 text-sm text-text-secondary leading-6 font-montserrat">
                                    Disabling Go Collaboration will remove this task from public collaboration.
                                    Existing collaborators may lose access, and pending requests may be cancelled.
                                </p>

                                <div class="flex justify-end gap-3 mt-6">

                                    <button
                                        type="button"
                                        @click="showDisableCollabWarning = false"
                                        class="px-4 py-2 rounded-xl bg-background border-2 border-border text-sm text-text-primary font-montserrat hover:bg-surface cursor-pointer"
                                    >
                                        Cancel
                                    </button>

                                    <button
                                        type="button"
                                        @click="
                                            task.go_collab_enabled = false;
                                            showCollab = false;
                                            showDisableCollabWarning = false;
                                        "
                                        class="px-4 py-2 rounded-xl bg-red-500 text-white text-sm font-montserrat hover:bg-red-accent cursor-pointer"
                                    >
                                        Disable
                                    </button>

                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- FOOTER --}}
                    <div class="border-t-2 border-border px-6 py-4 flex justify-between font-montserrat gap-3 shrink-0">
                        <div>
                            <template x-if="!editing">
                                <button
                                    @click="edit()"
                                    class="bg-quartiary text-white px-5 py-2.5 rounded-2xl hover:bg-quartiary-hover transition cursor-pointer"
                                >
                                    Edit Task
                                </button>
                            </template>

                            <template x-if="editing">
                                <div class="flex gap-2">
                                    <button
                                        type="button"
                                        @click="save()"
                                        class="bg-quartiary text-white px-5 py-2 rounded-2xl hover:bg-quartiary-hover transition cursor-pointer"
                                    >
                                        Save Changes
                                    </button>

                                    <button
                                        type="button"
                                        @click="cancelEdit()"
                                        class="border-2 border-red-accent text-red-accent cursor-pointer px-5 py-2.5 rounded-2xl transition hover:bg-surface bg-background font-montserrat font-semibold"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </template>
                        </div>
                        
                        <button
                            @click="close()"
                            class="border border-gray-200 px-5 py-2.5 rounded-2xl hover:bg-surface transition text-text-primary cursor-pointer ml-2"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection 