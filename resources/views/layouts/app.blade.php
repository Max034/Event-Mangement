<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EventHub') &middot; {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .hero-gradient { 
            background: linear-gradient(135deg, #6366f1, #8b5cf6, #ec4899, #6366f1);
            background-size: 300% 300%;
            animation: gradientMove 10s ease infinite;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

<nav class="bg-white border-b border-slate-200 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-extrabold text-xl">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg hero-gradient text-white">E</span>
                <span class="bg-clip-text text-transparent hero-gradient">EventHub</span>
            </a>
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium hover:text-indigo-600">Browse Events</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm font-medium hover:text-indigo-600">Dashboard</a>
                    @if(auth()->user()->isOrganizer() || auth()->user()->isAdmin())
                        <a href="{{ route('organizer.events.index') }}" class="px-3 py-2 text-sm font-medium hover:text-indigo-600">My Events</a>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 text-sm font-medium hover:text-indigo-600">Categories</a>
                        <a href="{{ route('admin.users.index') }}" class="px-3 py-2 text-sm font-medium hover:text-indigo-600">Users</a>
                    @endif
                    <a href="{{ route('bookings.index') }}" class="px-3 py-2 text-sm font-medium hover:text-indigo-600">My Tickets</a>
                @endauth
            </div>
            <div class="flex items-center gap-2">
                @auth
                    <span class="hidden sm:inline-flex items-center gap-2 text-sm">
                        <span class="w-8 h-8 rounded-full hero-gradient text-white inline-flex items-center justify-center font-semibold">
                            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                        </span>
                        <span class="text-slate-700">{{ auth()->user()->name }}</span>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700 capitalize">{{ auth()->user()->role }}</span>
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-3 py-1.5 text-sm rounded-md text-slate-700 hover:bg-slate-100">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-1.5 text-sm rounded-md hover:bg-slate-100">Login</a>
                    <a href="{{ route('register') }}" class="px-3 py-1.5 text-sm rounded-md text-white hero-gradient">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">{{ session('success') }}</div>
    </div>
@endif
@if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="rounded-lg bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">{{ session('error') }}</div>
    </div>
@endif

<main class="flex-1">
    @yield('content')
</main>

<footer class="mt-16 bg-slate-900 text-slate-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid md:grid-cols-3 gap-8">
        <div>
            <div class="flex items-center gap-2 text-white font-extrabold text-xl mb-3">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg hero-gradient">E</span>
                EventHub
            </div>
            <p class="text-sm text-slate-400">Discover, host, and book amazing events. Concerts, workshops, meetups, conferences — all in one place.</p>
        </div>
        <div>
            <h4 class="text-white font-semibold mb-3">Explore</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('home') }}" class="hover:text-white">All Events</a></li>
                <li><a href="{{ route('home', ['when' => 'today']) }}" class="hover:text-white">Today</a></li>
                <li><a href="{{ route('home', ['when' => 'week']) }}" class="hover:text-white">This Week</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-white font-semibold mb-3">Powered by</h4>
            <p class="text-sm text-slate-400">Laravel 11 &middot; MongoDB &middot; Tailwind CSS</p>
        </div>
    </div>
    <div class="border-t border-slate-800 py-4 text-center text-xs text-slate-500">&copy; {{ date('Y') }} EventHub. All rights reserved.</div>
</footer>

</body>
</html>
