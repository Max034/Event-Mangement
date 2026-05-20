@extends('layouts.app')
@section('title', 'My Events')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold">My Events 🎤</h1>
            <p class="text-slate-500 text-sm">Manage events you've created.</p>
        </div>
        <a href="{{ route('organizer.events.create') }}" class="hero-gradient text-white px-5 py-2.5 rounded-lg font-semibold">+ New Event</a>
    </div>

    @if($events->isEmpty())
        <div class="mt-8 text-center py-16 bg-white rounded-2xl border border-dashed">
            <div class="text-5xl mb-2">🎪</div>
            <p>No events yet. Create your first event!</p>
        </div>
    @else
        <div class="mt-6 overflow-x-auto bg-white border rounded-2xl">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Event</th>
                        <th class="px-4 py-3 font-semibold">Date</th>
                        <th class="px-4 py-3 font-semibold">Sold</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($events as $e)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="font-semibold">{{ $e->title }}</div>
                                <div class="text-xs text-slate-500">{{ $e->venue }}, {{ $e->city }}</div>
                            </td>
                            <td class="px-4 py-3">{{ $e->starts_at?->format('M j, Y g:i A') }}</td>
                            <td class="px-4 py-3">{{ $e->seats_booked ?? 0 }} / {{ $e->capacity }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs px-2 py-1 rounded-full capitalize
                                    @if($e->status === 'published') bg-emerald-100 text-emerald-700
                                    @elseif($e->status === 'draft') bg-slate-100 text-slate-700
                                    @else bg-red-100 text-red-700 @endif">{{ $e->status }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('events.show', $e->_id) }}" class="text-indigo-600 hover:underline">View</a>
                                <a href="{{ route('organizer.events.edit', $e->_id) }}" class="ml-3 text-slate-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('organizer.events.destroy', $e->_id) }}" class="inline ml-3" onsubmit="return confirm('Delete this event?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $events->links() }}</div>
    @endif
</div>
@endsection
