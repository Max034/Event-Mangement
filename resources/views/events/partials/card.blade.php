<a href="{{ route('events.show', $event->_id) }}" class="group bg-white rounded-2xl overflow-hidden border border-slate-200 hover:border-indigo-300 hover:shadow-lg transition flex flex-col">
    <div class="relative aspect-[16/9] bg-slate-200 overflow-hidden">
        @if($event->image)
            <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
        @else
            <div class="w-full h-full hero-gradient flex items-center justify-center text-white text-5xl font-bold">
                {{ strtoupper(substr($event->title,0,1)) }}
            </div>
        @endif
        @if($event->is_featured)
            <span class="absolute top-3 left-3 text-xs bg-amber-400 text-amber-900 font-semibold px-2 py-1 rounded-full">⭐ Featured</span>
        @endif
        @if($event->isSoldOut())
            <span class="absolute top-3 right-3 text-xs bg-red-500 text-white font-semibold px-2 py-1 rounded-full">SOLD OUT</span>
        @endif
    </div>
    <div class="p-5 flex-1 flex flex-col">
        <div class="text-xs font-semibold text-indigo-600 uppercase tracking-wide">
            {{ optional($event->category)->name ?? 'Event' }}
        </div>
        <h3 class="mt-1 font-bold text-lg text-slate-900 group-hover:text-indigo-600 line-clamp-2">{{ $event->title }}</h3>
        <div class="mt-2 text-sm text-slate-500 space-y-1">
            <div>📅 {{ $event->starts_at?->format('D, M j, Y · g:i A') }}</div>
            <div>📍 {{ $event->venue }}, {{ $event->city }}</div>
        </div>
        <div class="mt-auto pt-4 flex items-center justify-between">
            <span class="font-bold text-slate-900">
                @if($event->price > 0) ₹{{ number_format($event->price, 2) }} @else FREE @endif
            </span>
            <span class="text-xs text-slate-500">{{ $event->seatsRemaining() }} seats left</span>
        </div>
    </div>
</a>
