@extends('layouts.app')
@section('title', 'Users')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-extrabold">Users 👥</h1>

    <div class="mt-6 bg-white border rounded-2xl overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold">Name</th>
                    <th class="px-4 py-3 font-semibold">Email</th>
                    <th class="px-4 py-3 font-semibold">Phone</th>
                    <th class="px-4 py-3 font-semibold">Role</th>
                    <th class="px-4 py-3 font-semibold">Joined</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($users as $u)
                    <tr>
                        <td class="px-4 py-3 font-semibold">{{ $u->name }}</td>
                        <td class="px-4 py-3">{{ $u->email }}</td>
                        <td class="px-4 py-3">{{ $u->phone ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('admin.users.role', $u->_id) }}" class="inline-flex items-center gap-2">
                                @csrf @method('PUT')
                                <select name="role" class="text-xs rounded border px-2 py-1">
                                    @foreach(['admin','organizer','attendee'] as $r)
                                        <option value="{{ $r }}" @selected($u->role === $r)>{{ ucfirst($r) }}</option>
                                    @endforeach
                                </select>
                                <button class="text-xs text-indigo-600 hover:underline">Update</button>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-slate-500">{{ $u->created_at?->diffForHumans() }}</td>
                        <td class="px-4 py-3 text-right">
                            @if((string)$u->_id !== (string)auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $u->_id) }}" onsubmit="return confirm('Delete user?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 text-sm hover:underline">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
