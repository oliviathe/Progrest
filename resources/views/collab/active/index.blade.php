@extends('layouts.app')

@section('title', 'Active Collaborations')

@section('content')

{{-- Header --}}
<div class="bg-primary rounded-b-4xl px-8 py-6 shadow-md">
    <div class="flex flex-col lg:flex-row justify-between gap-6">
        <div>
            <h1 class="text-4xl font-bold font-montserrat text-white">
                Active Collaborations
            </h1>
            <p class="text-white/80 mt-2 font-montserrat">
                Manage every collaboration you've joined.
            </p>
        </div>

        {{-- Search --}}
        <form method="GET" class="relative">
            <input
                type="hidden"
                name="sort"
                value="{{ request('sort', 'deadline') }}"
            >
            <input
                type="hidden"
                name="direction"
                value="{{ request('direction', 'asc') }}"
            >
            <div class="absolute pl-4 mt-2.5">
                <x-lucide-search class="w-5 text-white"/>
            </div>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search active collaborations..."
                onchange="this.form.submit()"
                class="w-80 md:w-96 py-2 rounded-xl bg-white/10 text-white pl-12 font-montserrat focus:outline-none"
            >
        </form>
    </div>
</div>

{{-- Toolbar --}}
<div class="px-8 mt-6 flex justify-between items-center">
    <div>
        <h2 class="font-montserrat text-2xl font-bold text-text-primary">
            {{ $activeCollabTasks->total() }}
            Active Collaborations
        </h2>
        <p class="text-text-secondary font-montserrat text-sm mt-1">
            Showing {{ $activeCollabTasks->firstItem() ?? 0 }}
            -
            {{ $activeCollabTasks->lastItem() ?? 0 }}
        </p>
    </div>

    @if($activeCollabTasks->count())

    <div class="relative">
        <form method="GET" class="flex gap-3">
            <input
                type="hidden"
                name="search"
                value="{{ request('search') }}"
            >
            <input
                id="directionInput"
                type="hidden"
                name="direction"
                value="{{ request('direction', 'asc') }}"
            >
            <button
                type="submit"
                name="direction"
                value="{{ request('direction') === 'asc' ? 'desc' : 'asc' }}"
                onclick="document.getElementById('directionInput').disabled = true"
                class="bg-background rounded-2xl p-2 shadow-sm hover:bg-surface transition-colors cursor-pointer"
            >
                <x-lucide-arrow-up-down class="w-5 h-5"/>
            </button>
            <select
                name="sort"
                onchange="this.form.submit()"
                class="bg-background rounded-3xl pr-7 pl-4 shadow-sm font-montserrat text-sm appearance-none cursor-pointer"
            >
                <option
                    value="deadline"
                    {{ request('sort') === 'deadline' ? 'selected' : '' }}
                >
                    Due Date
                </option>
                <option
                    value="alphabetical"
                    {{ request('sort') === 'alphabetical' ? 'selected' : '' }}
                >
                    Alphabetical
                </option>
                <option
                    value="joined"
                    {{ request('sort') === 'joined' ? 'selected' : '' }}
                >
                    Joined Date
                </option>
            </select>
            <x-lucide-chevron-down
                class="absolute right-2 top-1/2 -translate-y-1/2 w-3.5 h-3.5"
            />
        </form>
    </div>
    @endif
</div>

{{-- Cards --}}
@if($activeCollabTasks->count())

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-8 mt-5">
    @foreach($activeCollabTasks as $task)
        @include('collab.active-collab-card', [
            'task' => $task
        ])

    @endforeach
</div>

<div class="px-8 mt-8 mb-10">
    {{ $activeCollabTasks->withQueryString()->links() }}
</div>

@else

<div class="mx-8 mt-6 mb-10 rounded-3xl bg-background shadow-sm p-10 text-center">

    <x-lucide-users class="w-12 h-12 mx-auto text-text-secondary"/>

    @if(request()->filled('search'))

        <h2 class="font-montserrat font-semibold text-text-primary mt-4">
            No active collaborations found
        </h2>
        <p class="text-text-secondary mt-2">
            No collaborations match
            <span class="font-semibold">
                "{{ request('search') }}"
            </span>.
        </p>

    @else

        <h2 class="font-montserrat font-semibold text-text-primary mt-4">
            You have no active collaborations
        </h2>
        <p class="text-text-secondary mt-2">
            Join a collaboration from the dashboard to start contributing.
        </p>
        <a
            href="{{ route('collab.index') }}"
            class="inline-flex mt-6 bg-primary text-white px-5 py-2.5 rounded-full font-semibold font-montserrat hover:bg-primary/90 transition-colors"
        >
            Browse Collaborations
        </a>
    @endif
</div>
@endif
@endsection