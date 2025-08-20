@extends('layouts.app') {{-- Sesuaikan dengan layout milikmu --}}

@section('content')
<div class="container mt-4">
    <h2>Tambah Dokumen</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('sops.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Judul --}}
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul') }}" required>
            @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- File Upload --}}
        <div class="mb-3">
            <label for="file" class="form-label">Unggah File</label>
            <input type="file" class="form-control @error('file') is-invalid @enderror" name="file" required>
            @error('file')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Author --}}
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        {{-- Submit --}}
        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
        <a href="{{ route('sops.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </form>
</div>
@endsection
