<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = User::with('opd');

        if (Auth::user()->role !== 'admin') {
            $query->where('opd_id', Auth::user()->opd_id);
        }

        $users = $query->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $opds = Opd::orderBy('name')->get();
        return view('users.create', compact('opds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,user',
            'password' => 'required|string|min:3',
            'opd_id' => 'required|exists:opds,id',
        ], [
            'opd_id.exists' => 'OPD yang dipilih tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 3 karakter.',
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'role.required' => 'Role harus dipilih.',
            'role.in' => 'Role harus salah satu dari admin atau user.',
            'opd_id.required' => 'OPD harus dipilih jika ada.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'opd_id' => $request->opd_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $opds = Opd::orderBy('name')->get();
        return view('users.edit', compact('user', 'opds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'role' => 'required|in:admin,user',
                'password' => 'nullable|string|min:3|confirmed',
                'opd_id' => 'required|exists:opds,id',
            ],
            [
                'opd_id.exists' => 'OPD yang dipilih tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'password.min' => 'Password minimal 3 karakter.',
                'name.required' => 'Nama harus diisi.',
                'email.required' => 'Email harus diisi.',
                'role.required' => 'Role harus dipilih.',
                'role.in' => 'Role harus salah satu dari admin atau user.',
                'opd_id.required' => 'OPD harus dipilih jika ada.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
            ]
        );

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->opd_id = $request->opd_id;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
