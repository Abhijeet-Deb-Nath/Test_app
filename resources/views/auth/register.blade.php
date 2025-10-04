@extends('layouts.app')

@section('title', 'Register - Love Journal')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white/90 backdrop-blur-sm rounded-2xl card-shadow p-8">
        <div class="text-center mb-8">
            <div class="text-6xl mb-4">💕</div>
            <h1 class="text-4xl font-bold text-rose mb-2">Love Journal</h1>
            <p class="text-gray-600">Begin your love story today</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 border-2 border-rose rounded-xl focus:outline-none focus:border-rose focus:ring-2 focus:ring-pink-200 transition @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 border-2 border-rose rounded-xl focus:outline-none focus:border-rose focus:ring-2 focus:ring-pink-200 transition @error('email') border-red-400 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-3 border-2 border-rose rounded-xl focus:outline-none focus:border-rose focus:ring-2 focus:ring-pink-200 transition @error('password') border-red-400 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-4 py-3 border-2 border-rose rounded-xl focus:outline-none focus:border-rose focus:ring-2 focus:ring-pink-200 transition">
            </div>

            <button type="submit" class="w-full heart-gradient text-white font-bold py-4 rounded-xl hover:opacity-90 transition transform hover:scale-105">
                Create Love Account
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-rose hover:underline font-semibold">Login here</a>
            </p>
        </div>
    </div>
</div>
@endsection
