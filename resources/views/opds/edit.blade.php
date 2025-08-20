@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit OPD</h3>

    <form action="{{ route('opds.update', $opd->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama OPD</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $opd->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-sm btn-primary">Update</button>
        <a href="{{ route('opds.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </form>
</div>
@endsection
