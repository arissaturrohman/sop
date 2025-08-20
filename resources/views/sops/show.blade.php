@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-10">
                <h4>Preview SOP : {{ $sop->judul }}</h4>
                <iframe src="{{ route('sops.stream', $sop->slug) }}"
                    style="border: 1px solid #ccc; width: 100%; height: 600px;"></iframe>

                {{-- <object id="pdf-viewer" data="{{ route('sops.stream', $sop->slug) }}" type="application/pdf" width="100%"
                    height="600px">
                    <p>PDF tidak dapat ditampilkan. <a href="{{ route('sops.stream', $sop->slug) }}">Unduh PDF</a></p>
                </object> --}}
            </div>
            <div class="col-2">
                <form id="approvalForm" action="{{ route('sops.update_status', $sop->id) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Status Persetujuan:</label><br>
                        <label class="me-3">
                            <input type="radio" name="status" value="disetujui">
                            ✅ A (Disetujui)
                        </label>
                        <label>
                            <input type="radio" name="status" value="ditolak">
                            ❌ B (Ditolak)
                        </label>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="feedbackBox" style="display: none; margin-top:10px;">
                        <label>Alasan Penolakan:</label>
                        <textarea name="feedback" class="form-control" id="feedback">{{ old('feedback') }}</textarea>
                        @error('feedback')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm mt-2">Kirim</button>
                    <a href="{{ route('sops.index') }}" class="btn btn-secondary btn-sm mt-2">Kembali</a>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const form = document.getElementById('approvalForm');
                        const statusRadios = form.querySelectorAll('input[name="status"]');
                        const feedbackBox = document.getElementById('feedbackBox');
                        const feedbackInput = document.getElementById('feedback');

                        // Tampilkan box feedback kalau pilih "ditolak"
                        statusRadios.forEach(radio => {
                            radio.addEventListener('change', function() {
                                if (this.value === 'ditolak') {
                                    feedbackBox.style.display = 'block';
                                } else {
                                    feedbackBox.style.display = 'none';
                                    feedbackInput.value = ''; // Kosongkan input feedback jika bukan ditolak
                                }
                            });
                        });

                        form.addEventListener('submit', function(e) {
                            const selectedStatus = form.querySelector('input[name="status"]:checked');
                            const feedbackValue = feedbackInput.value.trim();

                            if (selectedStatus && selectedStatus.value === 'ditolak' && feedbackValue === '') {
                                e.preventDefault(); // cegah submit
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Feedback wajib diisi',
                                    text: 'Mohon berikan alasan penolakan sebelum melanjutkan.',
                                });
                            }
                        });
                    });
                </script>
            </div>
        </div>
    @endsection
