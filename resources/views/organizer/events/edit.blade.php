@extends('layouts.app')
@section('title', 'Edit Event')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-extrabold">Edit event ✏️</h1>

    <form method="POST" action="{{ route('organizer.events.update', $event->_id) }}" enctype="multipart/form-data" class="mt-6 bg-white border rounded-2xl p-6">
        @method('PUT')
        @include('organizer.events._form', ['submitLabel' => 'Update Event'])
    </form>
</div>
@endsection
