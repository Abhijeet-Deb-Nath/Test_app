@extends('layouts.app')

@section('title', 'Create Memory - Love Journal')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl card-shadow p-10">
        <div class="text-center mb-8">
            <div class="text-7xl mb-4">✨</div>
            <h1 class="text-4xl font-bold text-rose mb-3">Create Memory Treasure</h1>
            <p class="text-gray-600 text-lg">Preserve a precious moment from your journey together</p>
        </div>

        <form action="{{ route('memories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Heading -->
            <div>
                <label for="heading" class="block text-gray-700 font-semibold mb-3 text-lg">
                    💫 Memory Heading <span class="text-red-500">*</span>
                </label>
                <input type="text" name="heading" id="heading" value="{{ old('heading') }}" required
                    class="w-full px-5 py-4 border-2 border-rose rounded-xl focus:outline-none focus:border-rose focus:ring-2 focus:ring-pink-200 transition text-lg @error('heading') border-red-400 @enderror"
                    placeholder="e.g., Our First Date">
                @error('heading')
                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title (Optional) -->
            <div>
                <label for="title" class="block text-gray-700 font-semibold mb-3 text-lg">
                    ✨ Subtitle (Optional)
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                    class="w-full px-5 py-4 border-2 border-rose rounded-xl focus:outline-none focus:border-rose focus:ring-2 focus:ring-pink-200 transition text-lg @error('title') border-red-400 @enderror"
                    placeholder="e.g., The day everything changed">
                @error('title')
                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Story Date -->
            <div>
                <label for="story_date" class="block text-gray-700 font-semibold mb-3 text-lg">
                    📅 Memory Date <span class="text-red-500">*</span>
                </label>
                <input type="date" name="story_date" id="story_date" value="{{ old('story_date') }}" required
                    max="{{ date('Y-m-d') }}"
                    class="w-full px-5 py-4 border-2 border-rose rounded-xl focus:outline-none focus:border-rose focus:ring-2 focus:ring-pink-200 transition text-lg @error('story_date') border-red-400 @enderror">
                @error('story_date')
                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-gray-700 font-semibold mb-3 text-lg">
                    📖 Memory Story (Optional)
                </label>
                <textarea name="description" id="description" rows="6"
                    class="w-full px-5 py-4 border-2 border-rose rounded-xl focus:outline-none focus:border-rose focus:ring-2 focus:ring-pink-200 transition text-lg @error('description') border-red-400 @enderror"
                    placeholder="Tell the story of this beautiful moment...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-2">Maximum 5000 characters</p>
            </div>

            <!-- Media Type -->
            <div>
                <label class="block text-gray-700 font-semibold mb-3 text-lg">
                    🎨 Memory Type <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-4 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="media_type" value="text" checked class="peer sr-only">
                        <div class="border-2 border-rose rounded-xl p-4 text-center peer-checked:bg-rose peer-checked:text-white transition">
                            <div class="text-3xl mb-2">📝</div>
                            <div class="font-semibold">Text</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="media_type" value="image" class="peer sr-only">
                        <div class="border-2 border-rose rounded-xl p-4 text-center peer-checked:bg-rose peer-checked:text-white transition">
                            <div class="text-3xl mb-2">📸</div>
                            <div class="font-semibold">Image</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="media_type" value="audio" class="peer sr-only">
                        <div class="border-2 border-rose rounded-xl p-4 text-center peer-checked:bg-rose peer-checked:text-white transition">
                            <div class="text-3xl mb-2">🎵</div>
                            <div class="font-semibold">Audio</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="media_type" value="video" class="peer sr-only">
                        <div class="border-2 border-rose rounded-xl p-4 text-center peer-checked:bg-rose peer-checked:text-white transition">
                            <div class="text-3xl mb-2">🎬</div>
                            <div class="font-semibold">Video</div>
                        </div>
                    </label>
                </div>
                @error('media_type')
                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror>
            </div>

            <!-- Media File Upload -->
            <div id="file-upload-section" class="hidden">
                <label for="media_file" class="block text-gray-700 font-semibold mb-3 text-lg">
                    📎 Upload Media File
                </label>
                <input type="file" name="media_file" id="media_file" accept=""
                    class="w-full px-5 py-4 border-2 border-rose rounded-xl focus:outline-none focus:border-rose focus:ring-2 focus:ring-pink-200 transition @error('media_file') border-red-400 @enderror">
                @error('media_file')
                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-2">
                    <span id="file-requirements">Max size: 100MB</span>
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex space-x-4 pt-6">
                <button type="submit" class="flex-1 heart-gradient text-white font-bold py-4 rounded-xl hover:opacity-90 transition transform hover:scale-105">
                    Create Memory Treasure 💕
                </button>
                <a href="{{ route('memories.index') }}" class="flex-1 bg-gray-300 text-gray-700 font-bold py-4 rounded-xl hover:bg-gray-400 transition text-center leading-none flex items-center justify-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Show/hide file upload based on media type
    document.querySelectorAll('input[name="media_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const fileSection = document.getElementById('file-upload-section');
            const fileInput = document.getElementById('media_file');
            const fileRequirements = document.getElementById('file-requirements');
            
            if (this.value === 'text') {
                fileSection.classList.add('hidden');
                fileInput.removeAttribute('required');
            } else {
                fileSection.classList.remove('hidden');
                fileInput.setAttribute('required', 'required');
                
                if (this.value === 'image') {
                    fileInput.setAttribute('accept', '.jpg,.jpeg,.png,.gif,.webp');
                    fileRequirements.textContent = 'Accepted formats: JPG, PNG, GIF, WEBP | Max size: 100MB';
                } else if (this.value === 'audio') {
                    fileInput.setAttribute('accept', '.mp3,.wav,.ogg');
                    fileRequirements.textContent = 'Accepted formats: MP3, WAV, OGG | Max size: 100MB';
                } else if (this.value === 'video') {
                    fileInput.setAttribute('accept', '.mp4,.avi,.mov,.wmv');
                    fileRequirements.textContent = 'Accepted formats: MP4, AVI, MOV, WMV | Max size: 100MB';
                }
            }
        });
    });
</script>
@endsection
