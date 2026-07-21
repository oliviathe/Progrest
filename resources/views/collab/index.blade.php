@extends('layouts.app') 

@section('title', 'Collab')

@section('content')
    {{-- HEADER --}}

    <div class="bg-primary rounded-b-4xl px-8 py-6 flex flex-col lg:flex-row gap-4 justify-between shadow-md">
        <div>
            <h1 class="font-montserrat text-white text-4xl font-bold">Collaboration</h1>
            <h3 class="font-montserrat text-white/80 text-md mt-2">Collab with other users to complete a project together.</h3>
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
                    placeholder="Search collabs..."
                    class="w-80 md:w-90 py-2 rounded-xl text-white text-md bg-white/10 font-montserrat pl-12 focus:outline-none transition-all duration-300"
                    onchange="this.form.submit()"
                >
            </form>
        </div>
    </div>

    {{-- Collab STATISTICS --}}
    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 px-8 py-6">

        {{-- Active Collabs --}}

        <div class="rounded-3xl bg-background shadow-sm flex flex-col p-4 gap-1 items-center">
            <div class="flex gap-3">
                <div class="w-10 h-10 rounded-3xl bg-pastel-green-background flex justify-center items-center">
                    <x-lucide-folder-open class="w-5 text-pastel-green-text"/> 
                </div>
                <p class="text-text-primary text-3xl font-montserrat font-semibold">??</p>
            </div>
            <p class="text-text-primary text-sm font-montserrat">Active Collabs</p>
        </div>
        
        {{-- Collabs Completed --}}

        <div class="rounded-3xl bg-background shadow-sm flex flex-col p-4 gap-1 items-center">
            <div class="flex gap-3">
                <div class="w-10 h-10 rounded-3xl bg-pastel-blue-background flex justify-center items-center">
                    <x-lucide-folder-check class="w-5 text-pastel-blue-text"/> 
                </div>
                <p class="text-text-primary text-3xl font-montserrat font-semibold">??</p>
            </div>
            <p class="text-text-primary text-sm font-montserrat">Collabs Completed</p>
        </div>

        {{-- Points Gained --}}

        <div class="rounded-3xl bg-background shadow-sm flex flex-col p-4 gap-1 items-center col-span-2 md:col-span-1">
            <div class="flex gap-3">
                <div class="w-10 h-10 rounded-3xl bg-pastel-yellow-background flex justify-center items-center">
                    <x-lucide-hand-coins class="w-5 text-pastel-yellow-text"/> 
                </div>
                <p class="text-text-primary text-3xl font-montserrat font-semibold">??</p>
            </div>
            <p class="text-text-primary text-sm font-montserrat">Points Gained</p>
        </div>
    </div>

    {{-- Display All Collaborable Tasks --}}

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4 items-start">
        @foreach ($tasks as $task)
            @include('collab.card', [
                'task' => $task,
            ]) 
        @endforeach
    </div>
@endsection
