<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $stats = [
                'users' => User::count(),
                'organizers' => User::where('role', User::ROLE_ORGANIZER)->count(),
                'events' => Event::count(),
                'published' => Event::where('status', Event::STATUS_PUBLISHED)->count(),
                'bookings' => Booking::where('status', Booking::STATUS_CONFIRMED)->count(),
                'categories' => Category::count(),
                'revenue' => (float) Booking::where('status', Booking::STATUS_CONFIRMED)->sum('total_amount'),
            ];
            $latestEvents = Event::orderBy('created_at', 'desc')->limit(5)->get();
            $latestBookings = Booking::orderBy('created_at', 'desc')->limit(5)->get();
            return view('dashboard.admin', compact('stats', 'latestEvents', 'latestBookings'));
        }

        if ($user->isOrganizer()) {
            $userId = (string) $user->_id;
            $myEvents = Event::where('organizer_id', $userId)->get();
            $eventIds = $myEvents->pluck('_id')->map(fn($i) => (string) $i)->all();
            $bookings = Booking::whereIn('event_id', $eventIds)
                ->where('status', Booking::STATUS_CONFIRMED)
                ->get();
            $stats = [
                'events' => $myEvents->count(),
                'published' => $myEvents->where('status', Event::STATUS_PUBLISHED)->count(),
                'bookings' => $bookings->count(),
                'tickets_sold' => $bookings->sum('tickets'),
                'revenue' => $bookings->sum('total_amount'),
            ];
            $upcomingEvents = $myEvents->where('starts_at', '>=', now())->sortBy('starts_at')->take(5);
            return view('dashboard.organizer', compact('stats', 'upcomingEvents'));
        }

        $myBookings = Booking::where('user_id', (string) $user->_id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $events = Event::whereIn('_id', $myBookings->pluck('event_id')->all())->get()->keyBy('_id');
        $upcoming = Event::where('status', Event::STATUS_PUBLISHED)
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->limit(6)
            ->get();
        return view('dashboard.attendee', compact('myBookings', 'events', 'upcoming'));
    }
}
