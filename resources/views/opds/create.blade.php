@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah OPD</h2>

    <form action="{{ route('opds.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama OPD</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
        <a href="{{ route('opds.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </form>
</div>
@endsection
