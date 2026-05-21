<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Event::query();

        if (! $user->isAdmin()) {
            $query->where('organizer_id', (string) $user->_id);
        }

        $events = $query->orderBy('starts_at', 'desc')->paginate(15);
        return view('organizer.events.index', compact('events'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('organizer.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['organizer_id'] = (string) Auth::id();
        $data['slug'] = Str::slug($data['title']).'-'.Str::random(5);
        $data['seats_booked'] = 0;
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = cloudinary()->uploadApi()->upload($request->file('image')->getRealPath())['secure_url'];
        }

        Event::create($data);
        return redirect()->route('organizer.events.index')->with('success', 'Event created.');
    }

    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        $this->authorizeOwner($event);
        $categories = Category::orderBy('name')->get();
        return view('organizer.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);
        $this->authorizeOwner($event);

        $data = $this->validated($request, $id);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = cloudinary()->uploadApi()->upload($request->file('image')->getRealPath())['secure_url'];
        }

        $event->update($data);
        return redirect()->route('organizer.events.index')->with('success', 'Event updated.');
    }

    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $this->authorizeOwner($event);
        $event->delete();
        return back()->with('success', 'Event deleted.');
    }

    protected function validated(Request $request, ?string $id = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string'],
            'venue' => ['required', 'string', 'max:160'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:80'],
            'starts_at' => ['required', 'date', 'after_or_equal:today'],
            'ends_at' => ['required', 'date', 'after_or_equal:starts_at'],
            'price' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
            'category_id' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'status' => ['required', 'in:draft,published,cancelled'],
        ]);
    }

    protected function authorizeOwner(Event $event): void
    {
        $user = Auth::user();
        if (! $user->isAdmin() && (string) $event->organizer_id !== (string) $user->_id) {
            abort(403);
        }
    }
}
