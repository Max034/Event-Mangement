@extends('layouts.app')
@section('title', 'Organizer Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-extrabold">Organizer Dashboard 🎤</h1>
    <p class="text-slate-500 text-sm">Track your events and bookings.</p>

    <div class="mt-6 grid grid-cols-2 md:grid-cols-5 gap-4">
        @foreach([
            ['Total Events','🎪', $stats['events']],
            ['Published','✅', $stats['published']],
            ['Bookings','🎟️', $stats['bookings']],
            ['Tickets Sold','📊', $stats['tickets_sold']],
            ['Revenue','💰', '₹'.number_format($stats['revenue'],2)],
        ] as $card)
            <div class="bg-white border rounded-2xl p-5">
                <div class="text-3xl">{{ $card[1] }}</div>
                <div class="text-2xl font-extrabold mt-2">{{ $card[2] }}</div>
                <div class="text-xs uppercase text-slate-500 mt-1">{{ $card[0] }}</div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 bg-white border rounded-2xl p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold">Your upcoming events</h3>
            <a href="{{ route('organizer.events.create') }}" class="hero-gradient text-white px-4 py-2 rounded-lg text-sm font-semibold">+ New Event</a>
        </div>
        @if($upcomingEvents->isEmpty())
            <p class="text-slate-500">No upcoming events. Create your first event!</p>
        @else
            <ul class="divide-y">
                @foreach($upcomingEvents as $e)
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <a href="{{ route('events.show', $e->_id) }}" class="font-semibold hover:text-indigo-600">{{ $e->title }}</a>
                            <div class="text-xs text-slate-500">{{ $e->starts_at?->format('M j, Y g:i A') }} · {{ $e->venue }}</div>
                        </div>
                        <div class="text-sm text-slate-500">{{ $e->seats_booked ?? 0 }}/{{ $e->capacity }} sold</div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
