@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-extrabold">Hello, {{ auth()->user()->name }} 👋</h1>
    <p class="text-slate-500 text-sm">Your tickets and recommended events.</p>

    <div class="mt-8 grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white border rounded-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold">Recent bookings</h3>
                <a href="{{ route('bookings.index') }}" class="text-sm text-indigo-600">View all</a>
            </div>
            @if($myBookings->isEmpty())
                <p class="text-slate-500 text-sm">You haven't booked anything yet. <a href="{{ route('home') }}" class="text-indigo-600">Browse events &rarr;</a></p>
            @else
                <ul class="divide-y">
                    @foreach($myBookings as $b)
                        @php $e = $events[$b->event_id] ?? null; @endphp
                        <li class="py-3 flex justify-between items-center text-sm">
                            <div>
                                <a href="{{ route('bookings.show', $b->_id) }}" class="font-semibold hover:text-indigo-600">{{ $e?->title ?? 'Event' }}</a>
                                <div class="text-xs text-slate-500">{{ $e?->starts_at?->format('M j, Y') }} · {{ $b->tickets }} ticket(s)</div>
                            </div>
                            <span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded">{{ $b->ticket_code }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="bg-white border rounded-2xl p-6">
            <h3 class="font-bold mb-4">Quick links</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-indigo-600 hover:underline">🔎 Browse Events</a></li>
                <li><a href="{{ route('bookings.index') }}" class="text-indigo-600 hover:underline">🎟️ My Tickets</a></li>
            </ul>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-xl font-bold mb-4">Recommended for you</h3>
        @if($upcoming->isEmpty())
            <p class="text-slate-500">No upcoming events at the moment.</p>
        @else
            <div class="grid md:grid-cols-3 gap-5">
                @foreach($upcoming as $e)
                    @include('events.partials.card', ['event' => $e])
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
