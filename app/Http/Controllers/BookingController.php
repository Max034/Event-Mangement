<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function create(string $eventId)
    {
        $event = Event::findOrFail($eventId);
        if ($event->isSoldOut() || ! $event->isUpcoming()) {
            return redirect()->route('events.show', $eventId)
                ->with('error', 'Sorry, this event is not available for booking.');
        }
        return view('bookings.create', compact('event'));
    }

    public function store(Request $request, string $eventId)
    {
        $event = Event::findOrFail($eventId);

        $data = $request->validate([
            'tickets' => ['required', 'integer', 'min:1', 'max:10'],
            'attendee_name' => ['required', 'string', 'max:120'],
            'attendee_email' => ['required', 'email', 'max:160'],
            'attendee_phone' => ['nullable', 'string', 'max:30'],
        ]);

        if ($data['tickets'] > $event->seatsRemaining()) {
            return back()
                ->withInput()
                ->withErrors(['tickets' => 'Only '.$event->seatsRemaining().' seats remaining.']);
        }

        $booking = Booking::create([
            'user_id' => (string) Auth::id(),
            'event_id' => (string) $event->_id,
            'tickets' => $data['tickets'],
            'total_amount' => $event->price * $data['tickets'],
            'status' => Booking::STATUS_CONFIRMED,
            'ticket_code' => strtoupper(Str::random(10)),
            'attendee_name' => $data['attendee_name'],
            'attendee_email' => $data['attendee_email'],
            'attendee_phone' => $data['attendee_phone'] ?? null,
        ]);

        $event->seats_booked = (int) ($event->seats_booked ?? 0) + (int) $data['tickets'];
        $event->save();

        return redirect()->route('bookings.show', $booking->_id)
            ->with('success', 'Booking confirmed! Your ticket code is '.$booking->ticket_code);
    }

    public function index()
    {
        $bookings = Booking::where('user_id', (string) Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $events = Event::whereIn('_id', $bookings->pluck('event_id')->all())->get()->keyBy('_id');

        return view('bookings.index', compact('bookings', 'events'));
    }

    public function show(string $id)
    {
        $booking = Booking::findOrFail($id);
        if ((string) $booking->user_id !== (string) Auth::id() && ! Auth::user()->isAdmin()) {
            abort(403);
        }
        $event = Event::find($booking->event_id);
        return view('bookings.show', compact('booking', 'event'));
    }

    public function cancel(string $id)
    {
        $booking = Booking::findOrFail($id);
        if ((string) $booking->user_id !== (string) Auth::id() && ! Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($booking->status === Booking::STATUS_CANCELLED) {
            return back()->with('error', 'Booking already cancelled.');
        }

        $event = Event::find($booking->event_id);
        if ($event) {
            $event->seats_booked = max(0, (int) ($event->seats_booked ?? 0) - (int) $booking->tickets);
            $event->save();
        }

        $booking->status = Booking::STATUS_CANCELLED;
        $booking->save();

        return back()->with('success', 'Booking cancelled.');
    }
}
