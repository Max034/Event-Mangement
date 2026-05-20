@extends('layouts.app')
@section('title', 'Categories')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-extrabold">Categories 🏷️</h1>

    <div class="mt-6 grid md:grid-cols-3 gap-6">
        <div class="md:col-span-1 bg-white border rounded-2xl p-6">
            <h3 class="font-bold mb-3">Add new</h3>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-3">
                @csrf
                <input type="text" name="name" placeholder="Category name" required class="w-full rounded-lg border px-3 py-2">
                <input type="text" name="icon" placeholder="Emoji (e.g. 🎵)" maxlength="8" class="w-full rounded-lg border px-3 py-2">
                <input type="text" name="description" placeholder="Description" class="w-full rounded-lg border px-3 py-2">
                <button class="w-full hero-gradient text-white font-semibold py-2 rounded-lg">Add Category</button>
            </form>
        </div>

        <div class="md:col-span-2 bg-white border rounded-2xl p-6">
            <h3 class="font-bold mb-4">All categories</h3>
            @if($categories->isEmpty())
                <p class="text-slate-500 text-sm">No categories yet.</p>
            @else
                <ul class="divide-y">
                    @foreach($categories as $c)
                        <li class="py-3 flex items-center justify-between">
                            <div>
                                <span class="text-xl">{{ $c->icon }}</span>
                                <span class="font-semibold ml-2">{{ $c->name }}</span>
                                <div class="text-xs text-slate-500 ml-7">{{ $c->description }}</div>
                            </div>
                            <form method="POST" action="{{ route('admin.categories.destroy', $c->_id) }}" onsubmit="return confirm('Delete category?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 text-sm hover:underline">Delete</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
