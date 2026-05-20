@extends('layouts.app')
@section('title', 'Your Ticket')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <a href="{{ route('bookings.index') }}" class="text-sm text-slate-500 hover:text-indigo-600">&larr; All bookings</a>

    <div class="mt-4 bg-white border rounded-2xl overflow-hidden">
        <div class="hero-gradient text-white p-6 text-center">
            <div class="text-3xl">🎟️</div>
            <h1 class="mt-1 text-2xl font-extrabold">{{ $event?->title ?? 'Event' }}</h1>
            <p class="text-sm opacity-90">{{ $event?->starts_at?->format('D, M j, Y · g:i A') }}</p>
        </div>

        <div class="p-6 space-y-4 text-sm">
            <div class="flex justify-between"><span class="text-slate-500">Ticket Code</span><span class="font-mono font-bold tracking-widest text-slate-900">{{ $booking->ticket_code }}</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Attendee</span><span>{{ $booking->attendee_name }}</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Email</span><span>{{ $booking->attendee_email }}</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Tickets</span><span>{{ $booking->tickets }}</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Total Paid</span><span class="font-bold">₹{{ number_format($booking->total_amount, 2) }}</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Status</span>
                <span class="capitalize font-semibold {{ $booking->status === 'confirmed' ? 'text-emerald-600' : 'text-red-600' }}">{{ $booking->status }}</span>
            </div>
            <div class="flex justify-between"><span class="text-slate-500">Venue</span><span class="text-right">{{ $event?->venue }}<br>{{ $event?->city }}</span></div>
        </div>

        @if($booking->status === 'confirmed' && $event && $event->isUpcoming())
            <form method="POST" action="{{ route('bookings.cancel', $booking->_id) }}" class="p-6 border-t bg-slate-50" onsubmit="return confirm('Cancel this booking?')">
                @csrf
                <button class="w-full text-red-600 font-semibold py-2 rounded-lg border border-red-200 hover:bg-red-50">Cancel Booking</button>
            </form>
        @endif
    </div>

    <p class="text-center text-xs text-slate-500 mt-4">Present this code at the venue entrance.</p>
</div>
@endsection
