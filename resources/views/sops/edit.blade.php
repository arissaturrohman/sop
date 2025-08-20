@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h2>Edit Dokumen</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('sops.update', $sop->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- User ID --}}
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">


            {{-- Judul --}}
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" class="form-control" name="judul" value="{{ old('judul', $sop->judul) }}" required>
            </div>

            {{-- File --}}
            <div class="mb-3">
                <label class="form-label">File (opsional)</label>
                <input type="file" class="form-control" name="file">
                @if ($sop->file)
                    <small class="form-text">
                        File saat ini: <a href="{{ asset('storage/' . $sop->file) }}" target="_blank">Lihat</a>
                    </small>
                @endif
            </div>

            {{-- Deskripsi --}}
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $sop->deskripsi) }}</textarea>
            </div>

            {{-- Status --}}
            @if ($sop->status === 'draft')
                <input type="hidden" name="status" value="{{ $sop->status }}">
            @else
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-control" id="statusSelect" name="status" required>
                        <option value="ditolak" {{ $sop->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        {{-- <option value="draft" {{ $sop->status == 'draft' ? 'selected' : '' }}>Draft</option> --}}
                        <!-- Tambahkan opsi lain jika perlu -->
                    </select>
                </div>
            @endif


            {{-- Feedback (jika ditolak) --}}
            <div class="mb-3" id="feedbackBox" style="display: none;">
                <label class="form-label">Feedback Penolakan</label>
                <textarea name="feedback" class="form-control" rows="3">{{ old('feedback', $sop->feedback) }}</textarea>
                @error('feedback')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-sm btn-success">Update</button>
            <a href="{{ route('sops.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
        </form>


        <script>
            function toggleFeedbackBox() {
                const status = document.getElementById('statusSelect').value;
                const feedbackBox = document.getElementById('feedbackBox');
                feedbackBox.style.display = (status === 'ditolak') ? 'block' : 'none';
            }

            // Initial check
            document.addEventListener('DOMContentLoaded', toggleFeedbackBox);

            // On change
            document.getElementById('statusSelect').addEventListener('change', toggleFeedbackBox);
        </script>

    </div>
@endsection
