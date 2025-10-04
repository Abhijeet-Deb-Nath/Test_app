@extends('layouts.app')

@section('title', 'Send Heart Connection - Love Journal')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl card-shadow p-10">
        <div class="text-center mb-8">
            <div class="text-7xl mb-4">💌</div>
            <h1 class="text-4xl font-bold text-rose mb-3">Send Heart Connection</h1>
            <p class="text-gray-600 text-lg">Invite someone special to create a shared love journal together</p>
        </div>

        <form action="{{ route('heart-connections.store') }}\" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="receiver_email" class="block text-gray-700 font-semibold mb-3 text-lg">
                    💕 Partner's Email Address
                </label>
                <input type="email" name="receiver_email" id="receiver_email" value="{{ old('receiver_email') }}\" required
                    class="w-full px-5 py-4 border-2 border-rose rounded-xl focus:outline-none focus:border-rose focus:ring-2 focus:ring-pink-200 transition text-lg @error('receiver_email') border-red-400 @enderror"
                    placeholder="partner@example.com">
                @error('receiver_email')
                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="message" class="block text-gray-700 font-semibold mb-3 text-lg">
                    ✨ Personal Message (Optional)
                </label>
                <textarea name="message" id="message" rows="5"
                    class="w-full px-5 py-4 border-2 border-rose rounded-xl focus:outline-none focus:border-rose focus:ring-2 focus:ring-pink-200 transition text-lg @error('message') border-red-400 @enderror"
                    placeholder="Add a sweet message to make it special...">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-2">Maximum 500 characters</p>
            </div>

            <div class="flex space-x-4 pt-4">
                <button type="submit" class="flex-1 heart-gradient text-white font-bold py-4 rounded-xl hover:opacity-90 transition transform hover:scale-105">
                    Send Heart Connection 💕
                </button>
                <a href="{{ route('dashboard') }}\" class="flex-1 bg-gray-300 text-gray-700 font-bold py-4 rounded-xl hover:bg-gray-400 transition text-center leading-none flex items-center justify-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
