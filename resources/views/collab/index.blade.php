@extends('layouts.app') 

@section('title', 'Collab')

@section('content')
<div class="p-4 md:p-8 pt-6 max-w-7xl mx-auto bg-linear-to-r from-surface to-background-gradient">
    
    <div class="bg-primary rounded-[32px] p-8 mb-10">
    
        <div class="flex items-center gap-4">
        
            <input
                id="searchCollab"
                type="text"
                placeholder="Search Collaboration"
                class="w-full rounded-full bg-white px-6 py-4
                       text-lg
                       placeholder-gray-400
                       border-none
                       focus:ring-2
                       focus:ring-green-300
                       outline-none">
        
            <select
                id="filterCollab"
                class="rounded-full px-5 py-4 bg-white
                       border-none
                       focus:ring-2
                       focus:ring-green-300">
        
                <option value="all">All</option>
                <option value="available">Available</option>
                <option value="joined">Joined</option>
                <option value="owner">Owned</option>
                <option value="full">Full</option>
        
            </select>
        
        </div>
    
    </div>

    <div class="flex justify-between items-center mb-6">

    <h1
        class="text-4xl font-extrabold">

        Trending Now

    </h1>

</div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        
        @foreach($projects as $project)

            @include('collab.card')

        @endforeach
        
        

    </div>

</div>
@include('collab.popup.join-modal')
@include('collab.script')
@endsection