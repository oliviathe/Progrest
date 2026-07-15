@extends('layouts.task') 

@section('title', 'Project - ' . $project->title)

@section('content')

    {{-- HEADER --}}
    <div class="bg-primary rounded-b-4xl px-8 py-6 flex flex-1 flex-col gap-4 justify-between shadow-md">
        <div class="flex flex-col lg:flex-row w-full justify-between items-center">
            <div class="flex flex-col lg:flex-row items-center gap-4 mb-4 lg:mb-0">
                <h1 class="font-montserrat text-white text-4xl font-bold">{{$project->title}}</h1>
                
                {{-- Collaborators Stack --}}
                <div class="flex items-center -space-x-2">
                    @foreach (array_slice($teamMembers, 0, $displayLimit) as $memberAvatar)
                        <img src="{{ $memberAvatar }}" alt="Collaborator" class="w-8 h-8 rounded-full border-2 border-white object-cover relative z-0">
                    @endforeach
                    
                    @if ($extraMembers > 0)
                        <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-xs font-semibold relative z-10 shadow-sm">
                            +{{ $extraMembers }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-end items-start">

                {{-- Search Bar --}} 
                <form method="GET" class="relative">

                    {{-- Simpan Hasil Sort Dulu --}}
                    <input type="hidden"
                        name="sort"
                        value="{{ request('sort', 'recent') }}"
                    >

                    {{-- Simpan Hasil Direction Dulu --}}
                    <input type="hidden"
                        name="direction"
                        value="{{ request('direction', 'desc') }}"
                    >
                    
                    <div class="absolute pl-4 mt-2.5">
                        <x-lucide-search class="w-5 text-black"/>
                    </div>

                    <input type="text"
                        name="search"
                        value="{{ request('search') }}" 
                        placeholder="Search task..."
                        class="w-75 md:w-83 py-2 rounded-full text-md bg-white font-montserrat pl-12 focus:outline-none transition-all duration-300"
                        onchange="this.form.submit()"
                    >
                        
                </form>

                {{-- CREATE TASK PANEL --}}
                <button onclick="openPanel()" @click="showCreateModal = true" class="bg-quartiary rounded-full px-6 py-2 h-fit flex items-center shadow-sm gap-2 hover:bg-quartiary-hover active:scale-95 text-sm md:text-base whitespace-nowrap">
                    <span class="font-montserrat text-white text-md">Create Task</span>
                    <div class="bg-primary rounded-full text-white p-0.5 flex items-center justify-center shrink-0">
                        <x-lucide-plus class="w-5 stroke-[2.5px]" />
                    </div>
                </button>
            </div>
        </div>

        <div class="flex items-center justify-center lg:justify-start">
            <x-lucide-notebook-pen class="w-6 h-6 p-1 text-white bg-primary-hover rounded-md"/> 
            <h3 class="font-montserrat text-md text-text-contrast/80 ml-3">{{$project->description}}</h3>
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
        <div class="px-8 pb-10">
            <div class="flex flex-col sm:flex-row justify-between items-center">
                <h1 class="font-montserrat text-text-primary text-2xl font-bold mb-3 sm:mb-0">All Tasks</h1>
                
                <div class="flex gap-4">

                    {{-- SORT BUTTON --}}

                    <form method="GET" class="flex gap-3">

                        {{-- Direction Toggle --}}
                        <button
                            type="submit"
                            name="direction"
                            value="{{ request('direction') === 'asc' ? 'desc' : 'asc' }}"
                            class="bg-background rounded-2xl p-2 shadow-sm hover:bg-surface transition-colors"
                        >
                            <x-lucide-arrow-up-down class="w-5 h-5 text-text-primary" />
                        </button>

                        {{-- Keep current sort --}}
                        <input type="hidden"
                            name="sort"
                            value="{{ request('sort', 'recent') }}">

                        {{-- Sort Dropdown --}}
                        <select
                            name="sort"
                            onchange="this.form.submit()"
                            class="bg-background rounded-3xl px-3 shadow-sm font-montserrat text-sm text-text-primary hover:bg-surface transition-colors focus:outline-none"
                        >
                            <option value="priority" class="outline-none"
                                {{ request('sort') === 'priority' ? 'selected' : '' }}>
                                Priority
                            </option>

                            <option value="alphabetical"
                                {{ request('sort') === 'alphabetical' ? 'selected' : '' }}>
                                Alphabetical
                            </option>

                            <option value="recent"
                                {{ request('sort') === 'deadline' ? 'selected' : '' }}>
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
        </div>
    @endif
@endsection 