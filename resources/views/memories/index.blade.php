@extends('layouts.app')

@section('title', 'Memory Treasures - Love Journal')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-rose hover:underline font-medium flex items-center">
            ← Back to Shared Space
        </a>
    </div>

    <div class="mb-10 flex justify-between items-center">
        <div>
            <h1 class="text-5xl font-bold text-rose mb-2">Memory Treasures 📸</h1>
            <p class="text-gray-600 text-lg">Your shared collection of precious moments</p>
        </div>
        <a href="{{ route('memories.create') }}" class="heart-gradient text-white font-bold py-3 px-8 rounded-xl hover:opacity-90 transition transform hover:scale-105">
            Create Memory ✨
        </a>
    </div>

    @if($memories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($memories as $memory)
                <a href="{{ route('memories.show', $memory) }}" 
                   class="bg-white/90 backdrop-blur-sm rounded-2xl card-shadow overflow-hidden hover:shadow-2xl transition transform hover:scale-105">
                    <!-- Memory Header -->
                    <div class="rose-gradient p-6">
                        <div class="flex items-start justify-between mb-3">
                            <div class="text-4xl">{{ $memory->getMediaIcon() }}</div>
                            <span class="text-sm text-gray-600 bg-white/70 px-3 py-1 rounded-full">
                                {{ $memory->story_date->format('M d, Y') }}
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-rose mb-2">{{ $memory->heading }}</h3>
                        @if($memory->title)
                            <p class="text-gray-700 font-medium">{{ $memory->title }}</p>
                        @endif
                    </div>

                    <!-- Memory Preview -->
                    <div class="p-6">
                        @if($memory->description)
                            <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($memory->description, 120) }}</p>
                        @endif

                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center space-x-2">
                                <span class="text-gray-500">Created by:</span>
                                <span class="font-semibold text-rose">{{ $memory->creator->name }}</span>
                            </div>
                            <div class="flex items-center space-x-1 text-gray-500">
                                <span>💭</span>
                                <span>{{ $memory->reflections->count() }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $memories->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl card-shadow p-16 text-center">
            <div class="text-8xl mb-6">📸</div>
            <h3 class="text-3xl font-bold text-gray-700 mb-4">No memories yet</h3>
            <p class="text-gray-600 text-lg mb-8">Start creating your first memory treasure together!</p>
            <a href="{{ route('memories.create') }}" class="heart-gradient text-white font-bold py-4 px-10 rounded-xl hover:opacity-90 transition transform hover:scale-105 inline-block">
                Create Your First Memory ✨
            </a>
        </div>
    @endif
</div>
@endsection
