@extends('layouts.projects-tasks') 

@section('title', 'Projects')

@section('content')

    {{-- HEADER --}}

    <div class="bg-primary rounded-b-4xl px-8 py-6 flex flex-col lg:flex-row gap-4 justify-between shadow-md">
        <div>
            <h1 class="font-montserrat text-white text-4xl font-bold">{{ __('main.proj.title') }}</h1>
            <h3 class="font-montserrat text-white/80 text-md mt-2">{{ __('main.proj.subtitle') }}</h3>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-end items-center">

            {{-- Search Bar --}} 
            <form method="GET" class="relative">

                {{-- Simpan Hasil Sort Dulu --}}
                <input type="hidden"
                    name="sort"
                    value="{{ request('sort', 'deadline') }}"
                >

                {{-- Simpan Hasil Direction Dulu --}}
                <input type="hidden"
                    name="direction"
                    value="{{ request('direction', 'desc') }}"
                >
                
                <div class="absolute pl-4 mt-2.5">
                    <x-lucide-search class="w-5 text-white"/>
                </div>

                <input type="text"
                    name="search"
                    value="{{ request('search') }}" 
                    placeholder="{{ __('main.ph.search-project-dot') }}"
                    class="w-80 md:w-90 py-2 rounded-xl text-white text-md bg-white/10 font-montserrat pl-12 focus:outline-none transition-all duration-300"
                    onchange="this.form.submit()"
                >
                    
            </form>

            {{-- CREATE PROJECT PANEL --}}
            <button onclick="openPanel()" class="bg-quartiary rounded-full px-6 py-2 h-fit flex items-center shadow-sm gap-2 hover:bg-quartiary-hover active:scale-95 text-sm md:text-base whitespace-nowrap cursor-pointer">
                <span class="font-montserrat text-white text-md">{{ __('main.proj.create') }}</span>
                <div class="bg-primary rounded-full text-white p-0.5 flex items-center justify-center shrink-0">
                    <x-lucide-plus class="w-5 stroke-[2.5px]" />
                </div>
            </button>
        </div>
    </div>

    {{-- PROJECT STATISTICS --}}

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 px-8 py-6">

        {{-- Active Projects --}}

        <div class="rounded-3xl bg-background shadow-sm flex flex-col p-4 gap-1 items-center">
            <div class="flex gap-3">
                <div class="w-10 h-10 rounded-3xl bg-pastel-green-background flex justify-center items-center">
                    <x-lucide-folder-open class="w-5 text-pastel-green-text"/> 
                </div>
                <p class="text-text-primary text-3xl font-montserrat font-semibold">{{ $activeProjects }}</p>
            </div>
            <p class="text-text-primary text-sm font-montserrat">{{ __('main.proj.active-projects') }}</p>
        </div>
        
        {{-- Projects Completed --}}

        <div class="rounded-3xl bg-background shadow-sm flex flex-col p-4 gap-1 items-center">
            <div class="flex gap-3">
                <div class="w-10 h-10 rounded-3xl bg-pastel-blue-background flex justify-center items-center">
                    <x-lucide-folder-check class="w-5 text-pastel-blue-text"/> 
                </div>
                <p class="text-text-primary text-3xl font-montserrat font-semibold">{{ $projectsDone }}</p>
            </div>
            <p class="text-text-primary text-sm font-montserrat">{{ __('main.proj.projects-done') }}</p>
        </div>

        {{-- Projects Led --}}

        <div class="rounded-3xl bg-background shadow-sm flex flex-col p-4 gap-1 items-center">
            <div class="flex gap-3">
                <div class="w-10 h-10 rounded-3xl bg-pastel-yellow-background flex justify-center items-center">
                    <x-lucide-user-star class="w-5 text-pastel-yellow-text"/> 
                </div>
                <p class="text-text-primary text-3xl font-montserrat font-semibold">{{ $projectsLed }}</p>
            </div>
            <p class="text-text-primary text-sm font-montserrat">{{ __('main.proj.projects-led') }}</p>
        </div>

        {{-- Team Members --}}

        <div class="rounded-3xl bg-background shadow-sm flex flex-col p-4 gap-1 items-center">
            <div class="flex gap-3">
                <div class="w-10 h-10 rounded-3xl bg-pastel-purple-background flex justify-center items-center">
                    <x-lucide-users class="w-5 text-pastel-purple-text"/> 
                </div>
                <p class="text-text-primary text-3xl font-montserrat font-semibold">{{ $teamMembers }}</p>
            </div>
            <p class="text-text-primary text-sm font-montserrat">{{ __('main.proj.team-members') }}</p>
        </div>
    </div>

    {{-- PROJECTS LIST --}}

    <div class="px-8">
        <div class="flex justify-between items-center">
            <h1 class="font-montserrat text-text-primary text-2xl font-bold">{{ __('main.proj.all-projects') }}</h1>
            
            <div class="relative gap-4">

                {{-- SORT BUTTON --}}

                <form method="GET" class="flex gap-3">

                    <input
                        id="directionInput"
                        type="hidden"
                        name="direction"
                        value="{{ request('direction', 'desc') }}"
                    >

                    <button
                        type="submit"
                        name="direction"
                        value="{{ request('direction') === 'asc' ? 'desc' : 'asc' }}"
                        onclick="document.getElementById('directionInput').disabled = true"
                        class="bg-background rounded-2xl p-2 shadow-sm hover:bg-surface transition-colors cursor-pointer"
                    >
                        <x-lucide-arrow-up-down class="w-5 h-5 text-text-primary"/>
                    </button>

                    {{-- Sort Dropdown --}}
                    <select
                        name="sort"
                        onchange="this.form.submit()"
                        class="bg-background rounded-3xl pr-7 pl-4 shadow-sm font-montserrat text-sm text-text-primary hover:bg-surface transition-colors focus:outline-none cursor-pointer appearance-none"
                    >
                        
                        <option value="deadline" class="outline-none"
                            {{ request('sort') === 'deadline' ? 'selected' : '' }}>
                            {{ __('main.proj.sort-due') }}
                        </option>

                        <option value="alphabetical"
                            {{ request('sort') === 'alphabetical' ? 'selected' : '' }}>
                            {{ __('main.proj.sort-alpha') }}
                        </option>

                        <option value="progress"
                            {{ request('sort') === 'progress' ? 'selected' : '' }}>
                            {{ __('main.proj.sort-progress') }}
                        </option>
                    </select>

                    <x-lucide-chevron-down class="w-3.5 h-3.5 absolute right-2 top-1/2 -translate-y-1/2 text-text-primary"/>

                </form>
            </div>
        </div>

        @if ($projects->isNotEmpty())
            <div class="mt-4 grid  grid-cols-1 md:grid-cols-2 gap-6 lg:grid-cols-3 mb-10">
                @foreach ($projects as $project)
                    @include('projects.card', [
                        'id' => $project->id,
                        'title' => $project->title,
                        'description' => $project->description,
                        'progress' => $project->getProgressAttribute(),
                        'collaborators' => $project->users,
                        'accentColor' => $project->accent, 
                        'icon' => $project->icon, 
                        'days_remaining' => $project->days_remaining
                    ])
                @endforeach
            </div>
        @else
            <div class="bg-background rounded-3xl p-6 text-center shadow-sm border border-border mb-10 mt-5">
                <p class="font-montserrat text-sm text-text-secondary">{{ __('main.proj.no-projects-at-all') }}</p>
            </div>
        @endif
    </div>
@endsection 