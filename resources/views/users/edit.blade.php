@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1>Edit User</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops!</strong> Ada kesalahan saat menyimpan data:<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
            </div>

            <div class="mb-3">
                <label>Role</label>
                @if (auth()->user()->role === 'admin')
                    <select name="role" class="form-control">
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                @else
                    <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                    <input type="hidden" name="role" value="{{ $user->role }}">
                @endif
            </div>

            <div class="mb-3">
                <label>OPD</label>
                @if (auth()->user()->role === 'admin')
                    <select name="opd_id" class="form-control">
                        <option value="">-- Pilih OPD --</option>
                        @foreach ($opds as $opd)
                            <option value="{{ $opd->id }}"
                                {{ old('opd_id', $user->opd_id) == $opd->id ? 'selected' : '' }}>
                                {{ $opd->name }}
                            </option>
                        @endforeach
                    </select>
                @else
                    {{-- Hanya tampilkan sebagai teks kalau user biasa --}}
                    <input type="text" class="form-control" value="{{ $user->opd->name ?? '-' }}" disabled>
                    {{-- Tetap kirim value aslinya biar tidak hilang di update --}}
                    <input type="hidden" name="opd_id" value="{{ $user->opd_id }}">
                @endif
            </div>


            <div class="mb-3">
                <label>Password (kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-sm btn-primary">Simpan Perubahan</button>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">Batal</a>
        </form>
    </div>
@endsection
