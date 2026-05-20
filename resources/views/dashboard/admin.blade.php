@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-extrabold">Admin Dashboard 🛡️</h1>
    <p class="text-slate-500 text-sm">Platform overview & stats.</p>

    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach([
            ['Users','👥', $stats['users'], 'indigo'],
            ['Organizers','🎤', $stats['organizers'], 'purple'],
            ['Events','🎪', $stats['events'], 'pink'],
            ['Published','✅', $stats['published'], 'emerald'],
            ['Bookings','🎟️', $stats['bookings'], 'amber'],
            ['Categories','🏷️', $stats['categories'], 'sky'],
            ['Revenue','💰', '₹'.number_format($stats['revenue'],2), 'rose'],
        ] as $card)
            <div class="bg-white border rounded-2xl p-5">
                <div class="text-3xl">{{ $card[1] }}</div>
                <div class="text-2xl font-extrabold mt-2">{{ $card[2] }}</div>
                <div class="text-xs uppercase text-slate-500 mt-1">{{ $card[0] }}</div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 grid md:grid-cols-2 gap-6">
        <div class="bg-white border rounded-2xl p-6">
            <h3 class="font-bold mb-4">Latest Events</h3>
            <ul class="space-y-3 text-sm">
                @forelse($latestEvents as $e)
                    <li class="flex justify-between"><a href="{{ route('events.show', $e->_id) }}" class="hover:text-indigo-600">{{ $e->title }}</a><span class="text-slate-500 text-xs">{{ $e->created_at?->diffForHumans() }}</span></li>
                @empty
                    <li class="text-slate-500">No events yet.</li>
                @endforelse
            </ul>
        </div>
        <div class="bg-white border rounded-2xl p-6">
            <h3 class="font-bold mb-4">Latest Bookings</h3>
            <ul class="space-y-3 text-sm">
                @forelse($latestBookings as $b)
                    <li class="flex justify-between"><span>{{ $b->attendee_name }} — {{ $b->tickets }} ticket(s)</span><span class="text-slate-500 text-xs">{{ $b->created_at?->diffForHumans() }}</span></li>
                @empty
                    <li class="text-slate-500">No bookings yet.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="mt-8 flex gap-3">
        <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-white border rounded-lg hover:bg-slate-50">Manage Users</a>
        <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 bg-white border rounded-lg hover:bg-slate-50">Manage Categories</a>
        <a href="{{ route('organizer.events.index') }}" class="px-5 py-2.5 bg-white border rounded-lg hover:bg-slate-50">All Events</a>
    </div>
</div>
@endsection
