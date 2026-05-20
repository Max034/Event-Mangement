@csrf
<div class="grid md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Event title *</label>
        <input type="text" name="title" value="{{ old('title', $event->title ?? '') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:ring-2 focus:ring-indigo-500">
        @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Description *</label>
        <textarea name="description" rows="5" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:ring-2 focus:ring-indigo-500">{{ old('description', $event->description ?? '') }}</textarea>
        @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Category *</label>
        <select name="category_id" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5">
            <option value="">Select a category</option>
            @foreach($categories as $c)
                <option value="{{ $c->_id }}" @selected(old('category_id', $event->category_id ?? '') == $c->_id)>{{ $c->icon }} {{ $c->name }}</option>
            @endforeach
        </select>
        @error('category_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Status *</label>
        <select name="status" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5">
            @foreach(['draft'=>'Draft','published'=>'Published','cancelled'=>'Cancelled'] as $k => $label)
                <option value="{{ $k }}" @selected(old('status', $event->status ?? 'draft') === $k)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Venue *</label>
        <input type="text" name="venue" value="{{ old('venue', $event->venue ?? '') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">City *</label>
        <input type="text" name="city" value="{{ old('city', $event->city ?? '') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Address</label>
        <input type="text" name="address" value="{{ old('address', $event->address ?? '') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Starts at *</label>
        <input type="datetime-local" name="starts_at" value="{{ old('starts_at', isset($event) && $event->starts_at ? $event->starts_at->format('Y-m-d\TH:i') : '') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Ends at *</label>
        <input type="datetime-local" name="ends_at" value="{{ old('ends_at', isset($event) && $event->ends_at ? $event->ends_at->format('Y-m-d\TH:i') : '') }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Price (₹) *</label>
        <input type="number" name="price" step="0.01" min="0" value="{{ old('price', $event->price ?? 0) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Capacity *</label>
        <input type="number" name="capacity" min="1" value="{{ old('capacity', $event->capacity ?? 50) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Image</label>
        @if(isset($event) && $event->image)
            <img src="{{ asset('storage/'.$event->image) }}" class="w-32 h-32 object-cover rounded-lg mb-2 border">
        @endif
        <input type="file" name="image" accept="image/*" class="w-full text-sm">
        @error('image') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="md:col-span-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_featured" value="1" class="rounded" @checked(old('is_featured', $event->is_featured ?? false))>
            <span class="text-sm">Mark as Featured ⭐</span>
        </label>
    </div>
</div>
<div class="mt-6 flex gap-3">
    <button class="hero-gradient text-white font-semibold px-6 py-2.5 rounded-lg">{{ $submitLabel ?? 'Save Event' }}</button>
    <a href="{{ route('organizer.events.index') }}" class="px-6 py-2.5 rounded-lg border hover:bg-slate-50">Cancel</a>
</div>
