@extends('layouts.app')
@section('title', 'Book - '.$event->title)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <a href="{{ route('events.show', $event->_id) }}" class="text-sm text-slate-500 hover:text-indigo-600">&larr; Back to event</a>
    <h1 class="mt-2 text-3xl font-extrabold">Book your tickets</h1>

    <div class="grid md:grid-cols-3 gap-6 mt-6">
        <div class="md:col-span-2 bg-white border rounded-2xl p-6">
            <form method="POST" action="{{ route('bookings.store', $event->_id) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Number of tickets</label>
                    <input type="number" name="tickets" min="1" max="{{ min(10, $event->seatsRemaining()) }}" value="{{ old('tickets', 1) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:ring-2 focus:ring-indigo-500">
                    <p class="text-xs text-slate-500 mt-1">{{ $event->seatsRemaining() }} seats remaining</p>
                    @error('tickets') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Attendee name</label>
                    <input type="text" name="attendee_name" value="{{ old('attendee_name', auth()->user()->name) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="attendee_email" value="{{ old('attendee_email', auth()->user()->email) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Phone (optional)</label>
                    <input type="text" name="attendee_phone" value="{{ old('attendee_phone', auth()->user()->phone) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:ring-2 focus:ring-indigo-500">
                </div>
                <button class="w-full hero-gradient text-white font-semibold py-3 rounded-xl hover:opacity-90">Confirm Booking</button>
            </form>
        </div>

        <aside>
            <div class="bg-white border rounded-2xl p-6 sticky top-24">
                <div class="text-xs uppercase text-slate-500 font-semibold">Order Summary</div>
                <h3 class="font-bold mt-1">{{ $event->title }}</h3>
                <div class="text-sm text-slate-500 mt-1">📅 {{ $event->starts_at?->format('M j, Y g:i A') }}</div>
                <div class="text-sm text-slate-500">📍 {{ $event->venue }}, {{ $event->city }}</div>
                <div class="mt-4 pt-4 border-t text-sm">
                    <div class="flex justify-between">
                        <span>Price per ticket</span>
                        <span>@if($event->price > 0) ₹{{ number_format($event->price, 2) }} @else FREE @endif</span>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
