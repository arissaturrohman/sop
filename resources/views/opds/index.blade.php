@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h4>Daftar OPD</h4>

        <a href="{{ route('opds.create') }}" class="btn btn-primary btn-sm mb-3">+ Tambah OPD</a>

        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nama</th>
                    <th>Kode</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($opds as $opd)
                    <tr>
                        <td>{{ $opd->name }}</td>
                        <td>{{ $opd->kode }}</td>
                        <td>
                            <a href="{{ route('opds.edit', $opd) }}" class="btn btn-warning btn-sm">Edit</a>
                            <x-delete-button :url="route('opds.destroy', $opd->id)" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
