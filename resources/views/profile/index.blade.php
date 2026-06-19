@extends('layouts.app')

@section('title', 'Profile')

@section('content')

@php
    $taskHelped = [
        [
            'project' => 'AquaVerse',
            'task' => 'Design Quiz Interface',
            'date' => 'Jan 2026',
            'point' => '+5',
            'color' => '#8B3F3F'
        ],
        [
            'project' => 'AquaVerse',
            'task' => 'Design Quiz Interface',
            'date' => 'Jan 2026',
            'point' => '+5',
            'color' => '#B89A3D'
        ],
        [
            'project' => 'AquaVerse',
            'task' => 'Design Quiz Interface',
            'date' => 'Jan 2026',
            'point' => '+5',
            'color' => '#2F6D92'
        ],
    ];

    $taskCreated = [
        [
            'project' => 'AquaVerse',
            'task' => 'Design Quiz Interface',
            'date' => 'Jan 2026',
            'point' => '-8',
            'color' => '#23824F'
        ]
    ];
@endphp

<div class="p-4 md:p-8 max-w-7xl mx-auto bg-linear-to-r from-surface to-background-gradient">
    <div class="bg-background rounded-4xl overflow-hidden shadow-sm border border-border mb-8">
        <!-- COVER -->
        <div class="relative h-36 overflow-visible">
            <img
                src="{{ asset('images/Checker_BG.png') }}"
                alt="Cover"
                class="absolute inset-0 w-full h-full object-cover"
            >
            <!-- EDIT -->
            <button
                class="absolute top-5 right-5 bg-primary hover:bg-primary-hover text-white px-5 py-2 rounded-full font-montserrat font-semibold flex items-center gap-2 shadow-md"
            >
                <x-lucide-pencil class="w-4 h-4" />
                Edit Profile
            </button>
        </div>
        <!-- PROFILE CONTENT -->
        <div class="relative px-10 pb-5">
            <!-- AVATAR -->
            <div class="absolute left-10 -top-14">
                <img
                    src="{{ asset('images/profile.jpg') }}"
                    class="w-48 h-48 rounded-full object-cover border-[6px] border-background shadow-lg"
                >
            </div>
            <!-- POINTS -->
            <div class="absolute right-10 top-6 bg-background-gradient pb-2 rounded-xl">
                <div class="flex items-center gap-3 flex-col">
                    <div class="bg-primary text-white rounded-lg px-4 py-2">
                        <span class="font-parkinsans text-3xl font-bold">
                            123
                        </span>
                    </div>
                    <span class="font-montserrat text-lg font-semibold text-text-primary">
                        Points
                    </span>
                </div>
            </div>

            <!-- PROFILE INFO -->
            <div class="pt-6.5 ml-54">
                <h1 class="font-parkinsans text-3xl font-bold text-text-primary">
                    {{ auth()->user()->username }}
                </h1>
                <p class="font-montserrat text-lg text-text-secondary mt-px">
                    @ {{ auth()->user()->name }}
                </p>
                <div class="flex flex-wrap items-center gap-5 mt-2 text-text-secondary">
                    <div class="flex items-center gap-2">
                        <x-lucide-map-pin class="w-4 h-4" />
                        Jakarta, Indonesia
                    </div>
                    <div class="flex items-center gap-2">
                        <x-lucide-calendar class="w-4 h-4" />
                        Joined Jan 2026
                    </div>
                </div>
                <p class="mt-2 max-w-lg font-montserrat text-text-secondary">
                    Passionate collaborator who enjoys building impactful
                    projects and helping teams deliver high-quality products.
                </p>
            </div>
        </div>

        <!-- STATS -->
        <div class="px-8 pb-4">
            <div class="grid grid-cols-2 md:grid-cols-4 bg-card border border-border rounded-3xl overflow-hidden">
                <div class="flex flex-col items-center py-3">
                    <div class="row flex gap-1.5 mb-1">
                        <div class="bg-primary p-2 rounded-xl flex items-center justify-center">
                            <x-lucide-folder-git class="w-4 h-4 text-text-contrast"/>
                        </div>
                        <span class="font-parkinsans text-3xl font-bold text-text-primary">4</span>
                    </div>
                    <span class="text-text-secondary">
                        Projects Joined
                    </span>
                </div>
                <div class="flex flex-col items-center py-3 border-l border-border">
                    <div class="row flex gap-1.5 mb-1">
                        <div class="bg-primary p-2 rounded-xl flex items-center justify-center">
                            <x-lucide-clipboard-list class="w-4 h-4 text-text-contrast"/>
                        </div>
                        <span class="font-parkinsans text-3xl font-bold text-text-primary">4</span>
                    </div>
                    <span class="text-text-secondary">
                        Tasks Completed
                    </span>
                </div>
                <div class="flex flex-col items-center py-3 border-l border-border">
                    <div class="row flex gap-1.5 mb-1">
                        <div class="bg-primary p-2 rounded-xl flex items-center justify-center">
                            <x-lucide-users class="w-4 h-4 text-text-contrast"/>
                        </div>
                        <span class="font-parkinsans text-3xl font-bold text-text-primary">4</span>
                    </div>
                    <span class="text-text-secondary">
                        Collaborations
                    </span>
                </div>
                <div class="flex flex-col items-center py-3 border-l border-border">
                    <div class="row flex gap-1.5 mb-1">
                        <div class="bg-primary p-2 rounded-xl flex items-center justify-center">
                            <x-lucide-star class="w-4 h-4 text-text-contrast"/>
                        </div>
                        <span class="font-parkinsans text-3xl font-bold text-text-primary">4</span>
                    </div>
                    <span class="text-text-secondary">
                        Total Points
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- ABOUT -->
        <div class="bg-background rounded-4xl p-7 shadow-sm border border-border flex flex-col justify-between">

            <div>

                <h2 class="font-parkinsans text-2xl font-semibold text-text-primary mb-5">
                    About
                </h2>

                <p class="font-montserrat text-text-secondary leading-relaxed text-[15px]">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>

            </div>

            <div class="mt-12 flex flex-col gap-5">

                <div class="flex items-center gap-3 text-text-secondary">
                    <x-lucide-mail class="w-5 h-5 text-primary" />

                    <span class="font-montserrat text-sm">
                        progressor@gmail.com
                    </span>
                </div>

                <div class="flex items-center gap-3 text-text-secondary">
                    <x-lucide-building-2 class="w-5 h-5 text-primary" />

                    <span class="font-montserrat text-sm">
                        Task Progressor
                    </span>
                </div>

            </div>
        </div>

        <!-- TASK HELPED -->
        <div class="bg-background rounded-4xl p-6 shadow-sm border border-border">

            <div class="flex items-center justify-between mb-5">

                <h2 class="font-parkinsans text-2xl font-semibold text-text-primary">
                    Tasks Helped
                </h2>

                <div class="bg-primary text-white px-3 py-1 rounded-lg font-parkinsans font-bold text-2xl leading-none">
                    12
                </div>

            </div>

            <div class="flex flex-col gap-4">

                @foreach($taskHelped as $task)

                    <div 
                        class="rounded-[1.4rem] p-5 text-white relative overflow-hidden"
                        style="background-color: {{ $task['color'] }}"
                    >

                        <div class="absolute top-4 right-4 w-8 h-8 bg-white rounded-full flex items-center justify-center text-sm font-bold text-black">
                            {{ $task['point'] }}
                        </div>

                        <h3 class="font-parkinsans text-2xl font-bold leading-none">
                            {{ $task['project'] }}
                        </h3>

                        <p class="font-montserrat text-sm mt-2">
                            {{ $task['task'] }}
                        </p>

                        <p class="font-montserrat text-sm mt-1">
                            {{ $task['date'] }}
                        </p>

                    </div>

                @endforeach

            </div>
        </div>

        <!-- TASK CREATED -->
        <div class="bg-background rounded-4xl p-6 shadow-sm border border-border">

            <div class="flex items-center justify-between mb-5">

                <h2 class="font-parkinsans text-2xl font-semibold text-text-primary">
                    Task Created
                </h2>

                <div class="bg-primary text-white px-3 py-1 rounded-lg font-parkinsans font-bold text-2xl leading-none">
                    1
                </div>

            </div>

            <div class="flex flex-col gap-4">

                @foreach($taskCreated as $task)

                    <div 
                        class="rounded-[1.4rem] p-5 text-white relative overflow-hidden"
                        style="background-color: {{ $task['color'] }}"
                    >

                        <div class="absolute top-4 right-4 w-8 h-8 bg-white rounded-full flex items-center justify-center text-sm font-bold text-black">
                            {{ $task['point'] }}
                        </div>

                        <h3 class="font-parkinsans text-2xl font-bold leading-none">
                            {{ $task['project'] }}
                        </h3>

                        <p class="font-montserrat text-sm mt-2">
                            {{ $task['task'] }}
                        </p>

                        <p class="font-montserrat text-sm mt-1">
                            {{ $task['date'] }}
                        </p>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

@endsection