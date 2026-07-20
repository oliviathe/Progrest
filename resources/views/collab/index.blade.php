@extends('layouts.app') 

@section('content')
<div class="p-4 md:p-8 pt-6 max-w-7xl mx-auto bg-linear-to-r from-surface to-background-gradient">
    
    <div class="bg-green-800 rounded-2xl p-4 mb-8">
        <input type="text" placeholder="{{ __('main.ph.search-project') }}" class="text-white placeholder:text-gray-300 bg-green-800">
    </div>

    <h1 class="text-text-primary text-4xl font-extrabold mb-6 text-black">{{ __('main.collab.trending') }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        @foreach($projects as $project)
        <div class="bg-background rounded-xl shadow-sm overflow-hidden p-4">
            
            <h2 class="text-text-primary text-2xl font-bold mb-1">{{ $project->title }}</h2>
            <p class="text-text-secondary text-600 mb-4 line-clamp-2">{{ $project->description }}</p>
            
            <img src="{{ $project->cover_url }}" class="w-full h-32 object-cover rounded-lg mb-4">
            
            <div class="flex justify-between text-xs text-gray-500 mb-4 font-semibold">
                <span>{{ __('main.collab.joined') }}: {{ $project->users_count }}/{{ $project->capacity ?? '∞' }}</span>
                <span>{{ __('main.collab.due') }}: {{ optional($project->deadline)->format('d M Y') ?? __('main.collab.none') }}</span>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img src="{{ $project->leader->avatar_url }}" alt="Avatar" class="w-6 h-6 rounded-full object-cover">
                    <span class="text-sm font-bold">{{ $project->leader_name }}</span>
                </div>
            </div>

            <button class="mt-4 w-full py-1.5 text-text-primary border-2 border-gray-300 rounded-full text-sm font-bold flex justify-center items-center gap-1 hover:bg-gray-50">
                {{ __('main.collab.view') }}
            </button>
        </div>
        @endforeach

    </div>
</div>
@endsection