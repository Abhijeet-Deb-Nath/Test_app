@extends('layouts.app')

@section('title', 'Login - Love Journal')

@section('content')
<div class="min-h-screen flex items-center justify-center gradient-bg">
    <div class="max-w-md w-full bg-white rounded-lg shadow-2xl p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">💕 Love Journal</h1>
            <p class="text-gray-600 mt-2">Welcome back!</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 flex items-center">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label for="remember" class="text-gray-700">Remember me</label>
            </div>

            <button type="submit" class="w-full heart-gradient text-white font-bold py-3 rounded-lg hover:opacity-90 transition">
                Login
            </button>
        </form>

        <p class="text-center text-gray-600 mt-6">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-purple-600 hover:underline font-medium">Register here</a>
        </p>
    </div>
</div>
@endsection
