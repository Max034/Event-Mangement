<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query()->where('status', Event::STATUS_PUBLISHED);

        if ($search = $request->get('q')) {
            $regex = new \MongoDB\BSON\Regex(preg_quote($search), 'i');
            $query->where(function ($q) use ($regex) {
                $q->where('title', 'regex', $regex)
                  ->orWhere('venue', 'regex', $regex)
                  ->orWhere('city', 'regex', $regex);
            });
        }

        if ($categoryId = $request->get('category')) {
            $query->where('category_id', $categoryId);
        }

        if ($city = $request->get('city')) {
            $query->where('city', 'regex', new \MongoDB\BSON\Regex(preg_quote($city), 'i'));
        }

        $when = $request->get('when');
        if ($when === 'today') {
            $query->whereBetween('starts_at', [now()->startOfDay(), now()->endOfDay()]);
        } elseif ($when === 'week') {
            $query->whereBetween('starts_at', [now(), now()->addWeek()]);
        } elseif ($when === 'month') {
            $query->whereBetween('starts_at', [now(), now()->addMonth()]);
        } else {
            $query->where('starts_at', '>=', now());
        }

        $events = $query->orderBy('starts_at', 'asc')->paginate(9)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $featured = Event::where('status', Event::STATUS_PUBLISHED)
            ->where('is_featured', true)
            ->where('starts_at', '>=', now())
            ->limit(3)
            ->get();

        return view('home', compact('events', 'categories', 'featured'));
    }

    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        $event->load(['category', 'organizer']);
        $related = Event::where('category_id', $event->category_id)
            ->where('_id', '!=', $event->_id)
            ->where('status', Event::STATUS_PUBLISHED)
            ->where('starts_at', '>=', now())
            ->limit(3)
            ->get();

        return view('events.show', compact('event', 'related'));
    }
}
