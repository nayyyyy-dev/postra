<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->hasRole('super-admin'), 403);

        $users = User::query()->with('roles')->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create(Request $request)
    {
        abort_unless($request->user()->hasRole('super-admin'), 403);
        return view('users.create');
    }

    public function store(Request $request)
    {
        abort_unless($request->user()->hasRole('super-admin'), 403);

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('users','email')],
            'password' => ['required','string','min:8'],
            'role' => ['required', Rule::in(['admin','supervisor'])], // super-admin khusus dev seed
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole($data['role']);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    public function destroy(Request $request, User $user)
    {
        abort_unless($request->user()->hasRole('super-admin'), 403);

        if ($user->hasRole('super-admin')) {
            return back()->with('success', 'Super-admin tidak boleh dihapus.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
