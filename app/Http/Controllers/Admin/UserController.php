<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, string $id)
    {
        $data = $request->validate([
            'role' => ['required', 'in:admin,organizer,attendee'],
        ]);
        $user = User::findOrFail($id);
        $user->role = $data['role'];
        $user->save();
        return back()->with('success', 'Role updated.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ((string) $user->_id === (string) auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }
}
