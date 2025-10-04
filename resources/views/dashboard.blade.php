@extends('layouts.app')

@section('title', 'Dashboard - Love Journal')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ $user->name }}! 💖</h1>
    </div>

    @if($couple && $partner)
        <!-- User is in a couple -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Love Space 💑</h2>
                <p class="text-gray-600 mb-4">Connected with {{ $partner->name }}</p>
                
                @if($couple->anniversary_date)
                    <p class="text-gray-500">Anniversary: {{ $couple->anniversary_date->format('F j, Y') }}</p>
                @endif
            </div>
            
            <div class="mt-8 text-center">
                <p class="text-gray-500 italic">Your shared couple space features will be available soon! 💕</p>
            </div>
        </div>
    @else
        <!-- User is not in a couple -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Send Heart Connection -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">💌 Send Heart Connection</h2>
                <p class="text-gray-600 mb-4">Connect with your special someone to create a shared love journal.</p>
                <a href="{{ route('heart-connections.create') }}" 
                   class="inline-block heart-gradient text-white font-bold py-2 px-6 rounded-lg hover:opacity-90 transition">
                    Send Request
                </a>
            </div>

            <!-- Pending Requests -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">💝 Pending Requests</h2>
                
                @if($pendingRequests->count() > 0)
                    <div class="space-y-4">
                        @foreach($pendingRequests as $request)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <p class="font-semibold text-gray-800">{{ $request->sender->name }}</p>
                                <p class="text-sm text-gray-600">{{ $request->sender->email }}</p>
                                
                                @if($request->message)
                                    <p class="text-gray-700 mt-2 italic">"{{ $request->message }}"</p>
                                @endif
                                
                                <div class="mt-4 flex space-x-2">
                                    <form action="{{ route('heart-connections.accept', $request) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                                            Accept ❤️
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('heart-connections.decline', $request) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition">
                                            Decline
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No pending requests.</p>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
