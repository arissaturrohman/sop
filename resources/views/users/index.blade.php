@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-heading">
            <h3>Pengguna</h3>
        </div>

        {{-- Tombol tambah hanya untuk admin --}}
        @auth
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm mb-3">Tambah Pengguna</a>
            @endif
        @endauth

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    @auth
                        @if (auth()->user()->role === 'admin')
                            Daftar Pengguna
                        @else
                            Pengaturan
                        @endif
                    @endauth
                </h5>
            </div>

            <div class="card-body">
                <table class="table table-bordered" @if (auth()->user()->role === 'admin') id="myTable" @endif>
                    <thead class="thead-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>OPD</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->opd->name ?? '-' }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>

                                    @if (auth()->user()->role === 'admin')
                                        <x-delete-button :url="route('users.destroy', $user->id)" />
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
