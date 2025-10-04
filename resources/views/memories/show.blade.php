@extends('layouts.app')

@section('title', $memory->heading . ' - Love Journal')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('memories.index') }}" class="text-rose hover:underline font-medium flex items-center">
            ← Back to Memory Treasures
        </a>
    </div>

    <!-- Memory Card -->
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl card-shadow overflow-hidden mb-8">
        <!-- Header -->
        <div class="rose-gradient p-10">
            <div class="flex items-start justify-between mb-4">
                <div class="text-6xl">{{ $memory->getMediaIcon() }}</div>
                <div class="text-right">
                    <span class="bg-white/70 px-4 py-2 rounded-full text-gray-700 font-semibold">
                        {{ $memory->story_date->format('F j, Y') }}
                    </span>
                </div>
            </div>
            <h1 class="text-4xl font-bold text-rose mb-3">{{ $memory->heading }}</h1>
            @if($memory->title)
                <p class="text-2xl text-gray-700 font-medium">{{ $memory->title }}</p>
            @endif
            
            <div class="mt-6 flex items-center text-gray-600">
                <span class="mr-2">Created by:</span>
                <span class="font-bold text-gray-800">{{ $memory->creator->name }}</span>
                <span class="mx-3">•</span>
                <span>{{ $memory->created_at->diffForHumans() }}</span>
            </div>
        </div>

        <!-- Memory Content -->
        <div class="p-10">
            @if($memory->description)
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">📖 The Story</h3>
                    <p class="text-gray-700 text-lg leading-relaxed whitespace-pre-wrap">{{ $memory->description }}</p>
                </div>
            @endif

            <!-- Media Section -->
            @if($memory->hasMedia())
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">
                        @if($memory->hasImage())
                            📸 Image Memory
                        @elseif($memory->hasAudio())
                            🎵 Audio Memory
                        @else
                            🎬 Video Memory
                        @endif
                    </h3>
                    
                    @if($memory->hasImage())
                        <img src="{{ $memory->getMediaUrl() }}" alt="{{ $memory->heading }}" class="w-full rounded-xl shadow-lg">
                    @elseif($memory->hasAudio())
                        <audio controls class="w-full rounded-xl shadow-lg">
                            <source src="{{ $memory->getMediaUrl() }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    @elseif($memory->hasVideo())
                        <video controls class="w-full rounded-xl shadow-lg">
                            <source src="{{ $memory->getMediaUrl() }}" type="video/mp4">
                            Your browser does not support the video element.
                        </video>
                    @endif
                </div>
            @endif

            <!-- Delete Button (Only for creator) -->
            @if($memory->created_by === Auth::id())
                <div class="border-t-2 border-gray-200 pt-6">
                    <form action="{{ route('memories.destroy', $memory) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this memory treasure? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm">
                            🗑️ Delete Memory
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Nostalgic Reflections Section -->
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl card-shadow p-10">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-rose mb-2">💭 Nostalgic Reflections</h2>
            <p class="text-gray-600">Deep thoughts and feelings about this cherished memory</p>
        </div>

        <!-- Reflections List -->
        @if($memory->reflections->count() > 0)
            <div class="space-y-6">
                @foreach($memory->reflections as $reflection)
                    <div class="rose-gradient rounded-xl p-6">
                        <!-- Reflection Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-pink-400 to-rose-400 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr($reflection->author->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-rose">{{ $reflection->author->name }}</div>
                                    <div class="text-sm text-gray-600">{{ $reflection->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            @if($reflection->user_id === Auth::id())
                                <form action="{{ route('reflections.destroy', $reflection) }}" method="POST" class="inline" onsubmit="return confirm('Delete this reflection?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                                </form>
                            @endif
                        </div>
                        
                        <!-- Reflection Text -->
                        <p class="text-gray-700 leading-relaxed whitespace-pre-wrap bg-white/60 rounded-lg p-4 mb-4">{{ $reflection->reflection_text }}</p>

                        <!-- Reply Comments on this Reflection -->
                        @if($reflection->comments->count() > 0)
                            <div class="space-y-4 mb-4 pl-8 border-l-4 border-white/40">
                                @foreach($reflection->comments as $comment)
                                    <div class="bg-white/80 rounded-lg p-4">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 bg-gradient-to-r from-pink-400 to-rose-400 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                    {{ substr($comment->author->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-sm text-rose">{{ $comment->author->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                            @if($comment->user_id === Auth::id())
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline" onsubmit="return confirm('Delete this reply?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Delete</button>
                                                </form>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $comment->comment_text }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Reply Form for this Reflection -->
                        <form action="{{ route('reflections.comments.store', $reflection) }}" method="POST" class="flex items-center space-x-2 pl-8">
                            @csrf
                            <input type="text" name="comment_text" required maxlength="1000"
                                class="flex-1 px-4 py-2 text-sm border-2 border-white/60 rounded-full focus:outline-none focus:border-white focus:ring-2 focus:ring-pink-200 transition bg-white/80"
                                placeholder="Reply to this reflection...">
                            <button type="submit" class="bg-gradient-to-r from-pink-400 to-rose-400 text-white font-bold p-2 rounded-full hover:opacity-90 transition w-8 h-8 flex items-center justify-center text-sm">
                                💬
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10 rose-gradient rounded-xl">
                <div class="text-6xl mb-4">💭</div>
                <p class="text-gray-600 italic">No reflections yet. Share your heartfelt thoughts below!</p>
            </div>
        @endif

        <!-- Add New Reflection Form -->
        <div class="mt-8 bg-gradient-to-r from-pink-50 to-rose-50 rounded-xl p-6 border-2 border-rose-200">
            <h3 class="text-xl font-bold text-rose mb-4">✨ Share Your Reflection</h3>
            <form action="{{ route('memories.reflections.store', $memory) }}" method="POST">
                @csrf
                <textarea 
                    name="reflection_text" 
                    rows="4" 
                    class="w-full px-4 py-3 border-2 border-rose-200 rounded-xl focus:outline-none focus:border-rose-400 resize-none" 
                    placeholder="Share your deep thoughts and feelings about this memory..."
                    required
                ></textarea>
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-pink-400 to-rose-400 text-white px-8 py-3 rounded-full font-bold hover:shadow-lg hover:scale-105 transition-all duration-200">
                        💭 Add Reflection
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
