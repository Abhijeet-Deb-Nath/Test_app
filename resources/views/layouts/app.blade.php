<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Love Journal')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
        
        body {
            background: linear-gradient(135deg, #ffeef8 0%, #fff5f7 25%, #ffe8f0 50%, #ffd6e8 75%, #ffcce0 100%);
            min-height: 100vh;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #ffeef8 0%, #ffe8f0 50%, #ffd6e8 100%);
        }
        
        .heart-gradient {
            background: linear-gradient(135deg, #ff6b9d 0%, #c44569 50%, #ff5e8c 100%);
            box-shadow: 0 4px 15px rgba(255, 107, 157, 0.3);
        }
        
        .heart-gradient:hover {
            background: linear-gradient(135deg, #ff5e8c 0%, #b23a5a 50%, #ff5486 100%);
            box-shadow: 0 6px 20px rgba(255, 107, 157, 0.4);
        }
        
        .rose-gradient {
            background: linear-gradient(135deg, #ffeef8 0%, #ffe0f0 100%);
        }
        
        .card-shadow {
            box-shadow: 0 10px 40px rgba(196, 69, 105, 0.1);
        }
        
        .text-rose {
            color: #c44569;
        }
        
        .bg-rose {
            background-color: #ffeef8;
        }
        
        .border-rose {
            border-color: #ffcce0;
        }
        
        .btn-soft-rose {
            background: linear-gradient(135deg, #ffe0f0 0%, #ffd6e8 100%);
            color: #c44569;
            border: 2px solid #ffcce0;
        }
        
        .btn-soft-rose:hover {
            background: linear-gradient(135deg, #ffd6e8 0%, #ffcce0 100%);
            border-color: #ff6b9d;
        }
        
        .input-rose:focus {
            border-color: #ff6b9d;
            ring-color: rgba(255, 107, 157, 0.3);
        }
        
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d4f4dd 0%, #c8f0d3 100%);
            color: #2d6a4f;
            border: 2px solid #95d5b2;
        }
        
        .alert-error {
            background: linear-gradient(135deg, #ffe0e0 0%, #ffd6d6 100%);
            color: #c44569;
            border: 2px solid #ffb3b3;
        }
        
        .alert-info {
            background: linear-gradient(135deg, #e0f0ff 0%, #d6e8ff 100%);
            color: #4569c4;
            border: 2px solid #b3d1ff;
        }
        
        .floating-hearts {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }
        
        .heart-particle {
            position: absolute;
            font-size: 20px;
            opacity: 0.1;
            animation: float 15s infinite;
        }
        
        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.1;
            }
            90% {
                opacity: 0.1;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }
        
        .content-wrapper {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>
    <!-- Floating hearts background -->
    <div class="floating-hearts">
        @for($i = 0; $i < 15; $i++)
            <div class="heart-particle" style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 15) }}s; animation-duration: {{ rand(10, 20) }}s;">
                💕
            </div>
        @endfor
    </div>

    <div class="content-wrapper">
        <!-- Navigation -->
        @auth
        <nav class="bg-white/80 backdrop-blur-sm border-b-2 border-rose shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <span class="text-3xl">💕</span>
                        <span class="text-2xl font-bold text-rose">Love Journal</span>
                    </a>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn-soft-rose px-4 py-2 rounded-lg font-medium transition hover:shadow-md">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        @endauth

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="alert alert-success">
                ✨ {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="alert alert-error">
                ⚠️ {{ session('error') }}
            </div>
        </div>
        @endif

        @if(session('info'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="alert alert-info">
                ℹ️ {{ session('info') }}
            </div>
        </div>
        @endif

        <!-- Main Content -->
        <main class="py-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
