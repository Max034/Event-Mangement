@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <h1 class="text-2xl font-extrabold text-slate-900">Welcome back 👋</h1>
        <p class="text-sm text-slate-500 mt-1">Sign in to manage your events and bookings.</p>

        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border-slate-300 border px-3 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" required class="w-full rounded-lg border-slate-300 border px-3 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember" class="rounded"> Remember me
            </label>
            <button class="w-full hero-gradient text-white font-semibold py-2.5 rounded-lg hover:opacity-90">Sign In</button>
        </form>

        <p class="mt-6 text-sm text-center text-slate-600">
            Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">Register</a>
        </p>
    </div>
</div>
@endsection
