@extends('layouts.app')

@section('title', 'Login - Love Journal')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white/90 backdrop-blur-sm rounded-2xl card-shadow p-8">
        <div class="text-center mb-8">
            <div class="text-6xl mb-4">💕</div>
            <h1 class="text-4xl font-bold text-rose mb-2">Love Journal</h1>
            <p class="text-gray-600">Welcome back to your love story</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            
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

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="mr-2 w-4 h-4 text-rose">
                <label for="remember" class="text-gray-700">Remember me</label>
            </div>

            <button type="submit" class="w-full heart-gradient text-white font-bold py-4 rounded-xl hover:opacity-90 transition transform hover:scale-105">
                Login to Your Love Space
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-gray-600">
                New here? 
                <a href="{{ route('register') }}" class="text-rose hover:underline font-semibold">Create your account</a>
            </p>
        </div>
    </div>
</div>
@endsection
