@extends('layouts.app')

@section('title', 'Heart Separation - Love Journal')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl card-shadow p-10">
        <div class="text-center mb-8">
            <div class="text-7xl mb-4">💔</div>
            <h1 class="text-4xl font-bold text-gray-700 mb-3">Heart Separation</h1>
            <p class="text-gray-600 text-lg">Sometimes paths diverge, and that's okay</p>
        </div>

        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-6 mb-8">
            <h3 class="font-bold text-yellow-800 mb-2">⚠️ Important Note</h3>
            <p class="text-yellow-700">
                Requesting a heart separation requires approval from your partner. Once approved, all shared content in your couple space will be permanently deleted.
            </p>
        </div>

        <form action="{{ route('heart-separations.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="reason" class="block text-gray-700 font-semibold mb-3 text-lg">
                    📝 Reason (Optional)
                </label>
                <textarea name="reason" id="reason" rows="6"
                    class="w-full px-5 py-4 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-gray-400 focus:ring-2 focus:ring-gray-200 transition text-lg @error('reason') border-red-400 @enderror"
                    placeholder="You can share your thoughts if you'd like...">{{ old('reason') }}</textarea>
                @error('reason')
                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-2">Maximum 1000 characters</p>
            </div>

            <div class="flex space-x-4 pt-4">
                <button type="submit" 
                    onclick="return confirm('Are you sure you want to request a heart separation? This action requires your partner\'s approval.')"
                    class="flex-1 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-bold py-4 rounded-xl hover:from-gray-600 hover:to-gray-700 transition transform hover:scale-105">
                    Request Separation 💔
                </button>
                <a href="{{ route('dashboard') }}" class="flex-1 btn-soft-rose font-bold py-4 rounded-xl transition text-center leading-none flex items-center justify-center">
                    Cancel
                </a>
            </div>
        </form>

        <div class="mt-8 text-center text-sm text-gray-500">
            <p>Need support? Remember to take care of yourself. 🌸</p>
        </div>
    </div>
</div>
@endsection
