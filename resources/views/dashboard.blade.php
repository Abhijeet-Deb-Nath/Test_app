@extends('layouts.app')

@section('title', 'Dashboard - Love Journal')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-10">
        <h1 class="text-5xl font-bold text-rose mb-2">Welcome, {{ $user->name }}! 💖</h1>
        <p class="text-gray-600 text-lg">Your personal love journey dashboard</p>
    </div>

    @if($couple && $partner)
        <!-- User is in a couple -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl card-shadow p-10 mb-8">
            <div class="text-center mb-8">
                <div class="text-7xl mb-4">💑</div>
                <h2 class="text-4xl font-bold text-rose mb-3">Your Love Space</h2>
                <p class="text-2xl text-gray-700 font-medium mb-2">{{ $user->name }} & {{ $partner->name }}</p>
                
                @if($couple->anniversary_date)
                    <p class="text-gray-500 text-lg">💝 Anniversary: {{ $couple->anniversary_date->format('F j, Y') }}</p>
                @endif
            </div>

            <!-- Pending Separation Notice -->
            @if($pendingSeparation)
                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-6 mb-6">
                    <h3 class="text-xl font-bold text-yellow-800 mb-3">⚠️ Pending Separation Request</h3>
                    
                    @if($pendingSeparation->requester_id === $user->id)
                        <!-- User is the requester -->
                        <p class="text-yellow-700 mb-4">You have requested a heart separation. Waiting for {{ $partner->name }}'s response...</p>
                        @if($pendingSeparation->reason)
                            <p class="text-yellow-600 italic mb-4">"{{ $pendingSeparation->reason }}"</p>
                        @endif
                        <form action="{{ route('heart-separations.cancel', $pendingSeparation) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 transition">
                                Cancel Request
                            </button>
                        </form>
                    @else
                        <!-- User is the responder -->
                        <p class="text-yellow-700 mb-4">{{ $partner->name }} has requested a heart separation.</p>
                        @if($pendingSeparation->reason)
                            <p class="text-yellow-600 italic mb-4">"{{ $pendingSeparation->reason }}"</p>
                        @endif
                        <div class="flex space-x-3">
                            <form action="{{ route('heart-separations.approve', $pendingSeparation) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Are you sure you want to approve this separation? This will delete all shared content.')" 
                                    class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition font-medium">
                                    Approve Separation 💔
                                </button>
                            </form>
                            
                            <form action="{{ route('heart-separations.decline', $pendingSeparation) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn-soft-rose px-6 py-3 rounded-lg font-medium transition">
                                    Decline & Continue Together 💕
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endif
            
            <div class="grid md:grid-cols-2 gap-6 mt-8">
                <div class="rose-gradient rounded-xl p-6 text-center">
                    <div class="text-5xl mb-3">📔</div>
                    <h3 class="text-xl font-bold text-rose mb-2">Shared Journal</h3>
                    <p class="text-gray-600 mb-4">Write your love story together</p>
                    <button class="btn-soft-rose px-6 py-2 rounded-lg font-medium" disabled>
                        Coming Soon
                    </button>
                </div>

                <div class="rose-gradient rounded-xl p-6 text-center">
                    <div class="text-5xl mb-3">📸</div>
                    <h3 class="text-xl font-bold text-rose mb-2">Memory Lane</h3>
                    <p class="text-gray-600 mb-4">Share special moments</p>
                    <button class="btn-soft-rose px-6 py-2 rounded-lg font-medium" disabled>
                        Coming Soon
                    </button>
                </div>
            </div>

            @if(!$pendingSeparation)
            <div class="mt-8 text-center">
                <a href="{{ route('heart-separations.create') }}" class="text-gray-400 hover:text-gray-600 text-sm underline">
                    Request Heart Separation
                </a>
            </div>
            @endif
        </div>
    @else
        <!-- User is not in a couple -->
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Send Heart Connection -->
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl card-shadow p-8 hover:shadow-2xl transition transform hover:scale-105">
                <div class="text-center">
                    <div class="text-6xl mb-4">💌</div>
                    <h2 class="text-2xl font-bold text-rose mb-4">Send Heart Connection</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">Connect with your special someone to create a shared love journal filled with memories and moments.</p>
                    <a href="{{ route('heart-connections.create') }}" 
                       class="inline-block heart-gradient text-white font-bold py-3 px-8 rounded-xl hover:opacity-90 transition transform hover:scale-105">
                        Send Request
                    </a>
                </div>
            </div>

            <!-- Pending Requests -->
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl card-shadow p-8">
                <div class="text-center mb-6">
                    <div class="text-6xl mb-4">💝</div>
                    <h2 class="text-2xl font-bold text-rose mb-2">Pending Requests</h2>
                </div>
                
                @if($pendingRequests->count() > 0)
                    <div class="space-y-4">
                        @foreach($pendingRequests as $request)
                            <div class="rose-gradient border-2 border-rose rounded-xl p-5">
                                <p class="font-bold text-rose text-lg">{{ $request->sender->name }}</p>
                                <p class="text-sm text-gray-600 mb-2">{{ $request->sender->email }}</p>
                                
                                @if($request->message)
                                    <div class="bg-white/60 rounded-lg p-3 my-3">
                                        <p class="text-gray-700 italic">"{{ $request->message }}"</p>
                                    </div>
                                @endif
                                
                                <div class="mt-4 flex space-x-3">
                                    <form action="{{ route('heart-connections.accept', $request) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full heart-gradient text-white px-4 py-3 rounded-lg hover:opacity-90 transition font-medium">
                                            Accept ❤️
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('heart-connections.decline', $request) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full bg-gray-300 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-400 transition font-medium">
                                            Decline
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center italic">No pending requests at the moment</p>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
