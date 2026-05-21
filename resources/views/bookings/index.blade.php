@extends('layouts.app')
@section('title', 'My Bookings')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-extrabold">My Bookings 🎟️</h1>
    <p class="text-slate-500 text-sm">All your tickets in one place.</p>

    @if($bookings->isEmpty())
        <div class="mt-8 text-center py-16 bg-white rounded-2xl border border-dashed">
            <div class="text-5xl mb-2">📭</div>
            <p>You haven't booked any events yet.</p>
            <a href="{{ route('home') }}" class="inline-block mt-4 hero-gradient text-white px-5 py-2 rounded-lg font-semibold">Browse Events</a>
        </div>
    @else
        <div class="mt-6 space-y-4">
            @foreach($bookings as $b)
                @php $e = $events[$b->event_id] ?? null; @endphp
                <a href="{{ route('bookings.show', $b->_id) }}" class="flex gap-4 bg-white border rounded-2xl p-4 hover:border-indigo-300 hover:shadow-sm">
                    <div class="w-24 h-24 rounded-xl overflow-hidden bg-slate-200 shrink-0">
                        @if($e && $e->image)
                            <img src="{{ Str::startsWith($e->image, ['http://', 'https://']) ? $e->image : asset('storage/'.$e->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full hero-gradient flex items-center justify-center text-white text-2xl font-bold">{{ strtoupper(substr($e?->title ?? '?',0,1)) }}</div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-slate-900">{{ $e?->title ?? 'Event' }}</div>
                        <div class="text-sm text-slate-500 mt-1">📅 {{ $e?->starts_at?->format('M j, Y · g:i A') }}</div>
                        <div class="text-sm text-slate-500">📍 {{ $e?->venue }}, {{ $e?->city }}</div>
                        <div class="mt-2 flex items-center gap-3 text-xs">
                            <span class="font-mono bg-slate-100 px-2 py-0.5 rounded">{{ $b->ticket_code }}</span>
                            <span class="capitalize {{ $b->status === 'confirmed' ? 'text-emerald-600' : 'text-red-600' }} font-semibold">● {{ $b->status }}</span>
                            <span class="text-slate-500">{{ $b->tickets }} ticket(s)</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold">₹{{ number_format($b->total_amount, 2) }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
