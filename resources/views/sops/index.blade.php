@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-heading">
            <h3>Dokumen</h3>
        </div>
        <a href="{{ route('sops.create') }}" class="btn btn-primary btn-sm mb-3">Tambah Dokumen</a>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Daftar Dokumen SOP
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover" id="myTable">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($sops as $sop)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sop->judul }}</td>
                                <td>{{ $sop->user->name }}</td>
                                <td>{{ ucfirst($sop->status) }}</span></td>
                                <td>
                                    @if ($sop->file)
                                        @if ($sop->status === 'tte')
                                            <a href="{{ asset('storage/' . $sop->file) }}"
                                                target="_blank">{{ $sop->file }}</a>
                                        @elseif ($sop->status === 'disetujui')
                                            <!-- Tombol TTE dengan Modal Konfirmasi -->
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#tteModal-{{ $sop->id }}">
                                                TTE
                                            </button>
                                            <div class="modal fade" id="tteModal-{{ $sop->id }}" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Konfirmasi TTE</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Anda yakin ingin menandatangani dokumen ini secara
                                                                elektronik?</p>
                                                            <form id="tteForm-{{ $sop->id }}"
                                                                action="{{ route('sops.tte.form', $sop->slug) }}"
                                                                method="POST">
                                                                @csrf
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Batal</button>
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="document.getElementById('tteForm-{{ $sop->id }}').submit()">
                                                                Ya, Tandatangani
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($sop->status === 'draft')
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#reviewModal-{{ $sop->id }}">
                                                Review
                                            </button>
                                            <div class="modal fade" id="reviewModal-{{ $sop->id }}" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog modal-xl" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('sops.review', $sop->slug) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Preview: {{ $sop->judul }}
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-4" style="height: 500px;">
                                                                    <iframe src="{{ route('sops.stream', $sop->slug) }}"
                                                                        style="width: 100%; height: 100%; border: 1px solid #ddd;"></iframe>
                                                                </div>
                                                                <div class="mt-3">
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-sm">Kirim</button>
                                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                                        data-bs-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#pdfModal-{{ $sop->id }}">
                                                Lihat
                                            </button>
                                            <div class="modal fade" id="pdfModal-{{ $sop->id }}" tabindex="-1"
                                                role="dialog" data-bs-backdrop="false">
                                                <div class="modal-dialog modal-xl" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Preview: {{ $sop->judul }}</h5>
                                                            {{-- <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button> --}}
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-4" style="height: 500px;">
                                                                <iframe src="{{ route('sops.stream', $sop->slug) }}"
                                                                    style="width: 100%; height: 100%; border: 1px solid #ddd;"></iframe>
                                                            </div>
                                                            <div class="approval-section mt-4 p-3 border rounded">
                                                                <form id="approvalForm-{{ $sop->id }}"
                                                                    action="{{ route('sops.update_status', $sop->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label><strong>Status
                                                                                Persetujuan:</strong></label>
                                                                        <div class="mt-2">
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input"
                                                                                    type="radio" name="status"
                                                                                    id="approve-{{ $sop->id }}"
                                                                                    value="disetujui">
                                                                                <label
                                                                                    class="form-check-label text-success"
                                                                                    for="approve-{{ $sop->id }}">✅
                                                                                    Disetujui</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input"
                                                                                    type="radio" name="status"
                                                                                    id="reject-{{ $sop->id }}"
                                                                                    value="ditolak">
                                                                                <label class="form-check-label text-danger"
                                                                                    for="reject-{{ $sop->id }}">❌
                                                                                    Ditolak</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id="feedbackBox-{{ $sop->id }}"
                                                                        class="form-group mt-3" style="display:none;">
                                                                        <label for="feedback-{{ $sop->id }}"><strong>Alasan
                                                                                Penolakan:</strong></label>
                                                                        <textarea name="feedback" id="feedback-{{ $sop->id }}" class="form-control" rows="3" required></textarea>
                                                                    </div>
                                                                    <div class="mt-3">
                                                                        <button type="submit"
                                                                            class="btn btn-primary btn-sm">Kirim</button>
                                                                        <button type="button"
                                                                            class="btn btn-secondary btn-sm"
                                                                            data-bs-dismiss="modal">Tutup</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <em>Tidak ada file</em>
                                    @endif
                                </td>
                                <td>
                                    @if (auth()->user()->role === 'admin')
                                        {{-- Admin: selalu bisa edit dan hapus --}}
                                        <a href="{{ route('sops.edit', $sop->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <button class="btn btn-sm btn-danger"
                                            onclick="confirmDelete('{{ route('sops.destroy', $sop->id) }}')">
                                            Hapus
                                        </button>
                                    @else
                                        {{-- User biasa: hanya draft atau ditolak yang bisa edit/hapus --}}
                                        @if (in_array($sop->status, ['draft', 'ditolak']))
                                            <a href="{{ route('sops.edit', $sop->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="confirmDelete('{{ route('sops.destroy', $sop->id) }}')">
                                                Hapus
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-warning"
                                                onclick="showBlockedAlert('{{ ucfirst($sop->status) }}')">Edit</button>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="showBlockedAlert('{{ ucfirst($sop->status) }}')">Hapus</button>
                                        @endif
                                    @endif
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function showBlockedAlert(status) {
            Swal.fire({
                icon: 'warning',
                title: 'Aksi Diblokir',
                text: `Dokumen tidak bisa diedit atau dihapus saat status "${status}"`,
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#3085d6'
            });
        }

        function confirmDelete(url) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Buat form dinamis untuk submit
                    const form = document.createElement('form');
                    form.action = url;
                    form.method = 'POST';
                    form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delegasi event untuk semua radio status
            document.querySelectorAll('input[type=radio][name="status"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    // Ambil ID numerik dari elemen radio (misal reject-3 → 3)
                    const sopId = this.id.split('-')[1];

                    const isRejected = document.getElementById(`reject-${sopId}`).checked;
                    const feedbackBox = document.getElementById(`feedbackBox-${sopId}`);
                    const feedbackInput = document.getElementById(`feedback-${sopId}`);

                    if (isRejected) {
                        feedbackBox.style.display = 'block';
                        feedbackInput.required = true;
                    } else {
                        feedbackBox.style.display = 'none';
                        feedbackInput.required = false;
                        feedbackInput.value = '';
                    }
                });
            });
        });
    </script>
@endsection
