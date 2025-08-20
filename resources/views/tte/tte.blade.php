@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Tanda Tangan Elektronik (Dummy)</h3>

    <p><strong>Judul SOP:</strong> {{ $sops->judul }}</p>

    @if ($sops->file)
        <iframe src="{{ asset('storage/' . $sops->file) }}" width="100%" height="500px"></iframe>
    @else
        <p class="text-danger">Dokumen tidak ditemukan.</p>
    @endif

    <form action="{{ route('sops.tte.sign', $sops->slug) }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-success">🔏 Proses TTE (Dummy)</button>
        <a href="{{ route('sops.index') }}" class="btn btn-secondary">Kembali</a>
    </form>

    @if (isset($dummyResult))
        <div class="alert alert-success mt-4">
            <strong>{{ $dummyResult['message'] }}</strong><br>
            Waktu: {{ $dummyResult['signed_at'] }}
        </div>
    @endif
</div>
@endsection
