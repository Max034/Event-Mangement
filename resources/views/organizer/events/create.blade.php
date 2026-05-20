@extends('layouts.app')
@section('title', 'Create Event')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-extrabold">Create a new event 🎉</h1>
    <p class="text-slate-500 text-sm">Fill in the details to publish your event.</p>

    <form method="POST" action="{{ route('organizer.events.store') }}" enctype="multipart/form-data" class="mt-6 bg-white border rounded-2xl p-6">
        @include('organizer.events._form', ['submitLabel' => 'Create Event'])
    </form>
</div>
@endsection
