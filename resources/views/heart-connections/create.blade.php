@extends('layouts.app')

@section('title', 'Send Heart Connection - Love Journal')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">💌 Send Heart Connection</h1>
            <p class="text-gray-600 mt-2">Invite someone special to create a shared love journal together.</p>
        </div>

        <form action="{{ route('heart-connections.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="receiver_email" class="block text-gray-700 font-medium mb-2">
                    Partner's Email Address
                </label>
                <input type="email" name="receiver_email" id="receiver_email" value="{{ old('receiver_email') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('receiver_email') border-red-500 @enderror"
                    placeholder="partner@example.com">
                @error('receiver_email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="message" class="block text-gray-700 font-medium mb-2">
                    Personal Message (Optional)
                </label>
                <textarea name="message" id="message" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('message') border-red-500 @enderror"
                    placeholder="Add a sweet message...">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Maximum 500 characters</p>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="flex-1 heart-gradient text-white font-bold py-3 rounded-lg hover:opacity-90 transition">
                    Send Heart Connection 💕
                </button>
                <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-300 text-gray-700 font-bold py-3 rounded-lg hover:bg-gray-400 transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
