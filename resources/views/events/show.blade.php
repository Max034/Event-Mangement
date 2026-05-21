@extends('layouts.app')
@section('title', $event->title)

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <a href="{{ route('home') }}" class="text-sm text-slate-500 hover:text-indigo-600">&larr; Back to events</a>

    <div class="grid lg:grid-cols-3 gap-8 mt-4">
        <div class="lg:col-span-2">
            <div class="aspect-[16/9] bg-slate-200 rounded-2xl overflow-hidden">
                @if($event->image)
                    <img src="{{ Str::startsWith($event->image, ['http://', 'https://']) ? $event->image : asset('storage/'.$event->image) }}" alt="" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full hero-gradient flex items-center justify-center text-white text-7xl font-bold">{{ strtoupper(substr($event->title,0,1)) }}</div>
                @endif
            </div>

            <div class="mt-6 flex flex-wrap items-center gap-2">
                @if($event->category)
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-indigo-100 text-indigo-700">{{ $event->category->icon }} {{ $event->category->name }}</span>
                @endif
                @if($event->is_featured)
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-amber-100 text-amber-800">⭐ Featured</span>
                @endif
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-slate-100 text-slate-700 capitalize">{{ $event->status }}</span>
            </div>

            <h1 class="mt-4 text-3xl md:text-4xl font-extrabold text-slate-900">{{ $event->title }}</h1>

            <div class="mt-4 grid sm:grid-cols-2 gap-4 text-sm">
                <div class="p-4 bg-white rounded-xl border">
                    <div class="text-slate-500">📅 When</div>
                    <div class="font-semibold mt-1">{{ $event->starts_at?->format('D, M j, Y') }}</div>
                    <div class="text-slate-700">{{ $event->starts_at?->format('g:i A') }} - {{ $event->ends_at?->format('g:i A') }}</div>
                </div>
                <div class="p-4 bg-white rounded-xl border">
                    <div class="text-slate-500">📍 Where</div>
                    <div class="font-semibold mt-1">{{ $event->venue }}</div>
                    <div class="text-slate-700">{{ $event->address }}{{ $event->address ? ', ' : '' }}{{ $event->city }}</div>
                </div>
            </div>

            <div class="mt-8 prose max-w-none">
                <h2 class="text-xl font-bold mb-2">About this event</h2>
                <div class="whitespace-pre-line text-slate-700">{{ $event->description }}</div>
            </div>

            @if($event->organizer)
                <div class="mt-8 p-4 bg-white rounded-xl border flex items-center gap-3">
                    <div class="w-12 h-12 hero-gradient rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($event->organizer->name,0,1)) }}
                    </div>
                    <div>
                        <div class="text-xs text-slate-500">Organized by</div>
                        <div class="font-semibold">{{ $event->organizer->name }}</div>
                    </div>
                </div>
            @endif
        </div>

        <aside class="lg:col-span-1">
            <div class="bg-white border rounded-2xl p-6 sticky top-24">
                <div class="text-3xl font-extrabold text-slate-900">
                    @if($event->price > 0) ₹{{ number_format($event->price, 2) }} @else FREE @endif
                </div>
                <div class="mt-2 text-sm text-slate-500">
                    {{ $event->seatsRemaining() }} of {{ $event->capacity }} seats remaining
                </div>
                <div class="mt-4 h-2 bg-slate-100 rounded-full overflow-hidden">
                    @php $pct = $event->capacity > 0 ? round((($event->seats_booked ?? 0) / $event->capacity) * 100) : 0; @endphp
                    <div class="h-full hero-gradient" style="width: {{ $pct }}%"></div>
                </div>

                @if($event->isSoldOut())
                    <button disabled class="mt-6 w-full bg-slate-200 text-slate-500 font-semibold py-3 rounded-xl cursor-not-allowed">Sold Out</button>
                @elseif(! $event->isUpcoming())
                    <button disabled class="mt-6 w-full bg-slate-200 text-slate-500 font-semibold py-3 rounded-xl cursor-not-allowed">Event Ended</button>
                @else
                    @auth
                        <a href="{{ route('bookings.create', $event->_id) }}" class="mt-6 w-full block text-center hero-gradient text-white font-semibold py-3 rounded-xl hover:opacity-90">Book Now</a>
                    @else
                        <a href="{{ route('login') }}" class="mt-6 w-full block text-center hero-gradient text-white font-semibold py-3 rounded-xl hover:opacity-90">Login to Book</a>
                    @endauth
                @endif

                <div class="mt-4 text-xs text-slate-500 text-center">Secure your spot — limited tickets available.</div>
            </div>
        </aside>
    </div>

    @if($related->count() > 0)
        <section class="mt-12">
            <h2 class="text-xl font-bold mb-4">You might also like</h2>
            <div class="grid md:grid-cols-3 gap-5">
                @foreach($related as $r)
                    @include('events.partials.card', ['event' => $r])
                @endforeach
            </div>
        </section>
    @endif
</section>
@endsection
