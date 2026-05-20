@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="max-w-md mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <h1 class="text-2xl font-extrabold text-slate-900">Create your account 🎉</h1>
        <p class="text-sm text-slate-500 mt-1">Join EventHub to book or host events.</p>

        <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Full name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:ring-2 focus:ring-indigo-500">
                @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:ring-2 focus:ring-indigo-500">
                @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Phone (optional)</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:ring-2 focus:ring-indigo-500">
                    @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Confirm</label>
                    <input type="password" name="password_confirmation" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">I want to</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="attendee" class="peer hidden" {{ old('role', 'attendee') === 'attendee' ? 'checked' : '' }}>
                        <div class="border-2 rounded-lg p-3 text-center text-sm peer-checked:border-indigo-500 peer-checked:bg-indigo-50">
                            🎟️<br><span class="font-semibold">Attend Events</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="organizer" class="peer hidden" {{ old('role') === 'organizer' ? 'checked' : '' }}>
                        <div class="border-2 rounded-lg p-3 text-center text-sm peer-checked:border-indigo-500 peer-checked:bg-indigo-50">
                            🎤<br><span class="font-semibold">Host Events</span>
                        </div>
                    </label>
                </div>
            </div>
            <button class="w-full hero-gradient text-white font-semibold py-2.5 rounded-lg hover:opacity-90">Create account</button>
        </form>

        <p class="mt-6 text-sm text-center text-slate-600">
            Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Sign in</a>
        </p>
    </div>
</div>
@endsection
