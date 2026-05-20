@extends('layouts.app')
@section('title', 'Discover Events')

@section('content')
<section class="hero-gradient text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight animate-fade-in-up delay-100">Find your next unforgettable experience</h1>
        <p class="mt-3 text-lg text-white/90 max-w-2xl animate-fade-in-up delay-200">Concerts, workshops, conferences, meetups — all the events you love, in one place.</p>

        <form method="GET" action="{{ route('home') }}" class="mt-8 grid md:grid-cols-4 gap-3 bg-white/15 backdrop-blur p-3 rounded-2xl animate-fade-in-up delay-300">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search events, venues..." class="md:col-span-2 rounded-xl px-4 py-3 text-slate-800 placeholder-slate-500 focus:ring-2 focus:ring-white">
            <select name="category" class="rounded-xl px-4 py-3 text-slate-800">
                <option value="">All categories</option>
                @foreach($categories as $c)
                    <option value="{{ $c->_id }}" @selected(request('category') == $c->_id)>{{ $c->icon }} {{ $c->name }}</option>
                @endforeach
            </select>
            <button class="rounded-xl bg-slate-900 hover:bg-black text-white font-semibold px-4 py-3">Search</button>
        </form>

        <div class="mt-4 flex flex-wrap gap-2">
            @foreach(['' => 'Upcoming','today' => 'Today','week' => 'This Week','month' => 'This Month'] as $key => $label)
                <a href="{{ route('home', array_filter(['when' => $key,'q' => request('q'),'category' => request('category')])) }}"
                   class="text-xs px-3 py-1.5 rounded-full {{ request('when',(string)'') === $key ? 'bg-white text-indigo-700 font-semibold' : 'bg-white/20 text-white' }}">{{ $label }}</a>
            @endforeach
        </div>
    </div>
</section>

@if($featured->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
    <h2 class="text-2xl font-bold mb-4">⭐ Featured</h2>
    <div class="grid md:grid-cols-3 gap-5">
        @foreach($featured as $event)
            @include('events.partials.card', ['event' => $event])
        @endforeach
    </div>
</section>
@endif

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 mb-12">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold">All Events</h2>
        <p class="text-sm text-slate-500">{{ $events->total() }} result(s)</p>
    </div>

    @if($events->count() === 0)
        <div class="text-center py-16 bg-white rounded-2xl border border-dashed">
            <div class="text-5xl mb-2">🔍</div>
            <p class="text-slate-600">No events match your search. Try a different filter.</p>
        </div>
    @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($events as $event)
                @include('events.partials.card', ['event' => $event])
            @endforeach
        </div>
        <div class="mt-6">{{ $events->links() }}</div>
    @endif
</section>
@endsection
