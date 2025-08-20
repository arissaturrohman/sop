@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h4>Preview SOP : {{ $sop->judul }}</h4>
    <canvas id="pdf-canvas" style="width: 100%; border:1px solid #ccc;"></canvas>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.0.379/pdf.min.js"></script>
<script>
    const url = "{{ route('sops.stream', $sop->slug) }}";

    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.blob())
    .then(blob => {
        const fileReader = new FileReader();
        fileReader.onload = function () {
            const typedarray = new Uint8Array(this.result);

            pdfjsLib.getDocument(typedarray).promise.then(function (pdf) {
                pdf.getPage(1).then(function (page) {
                    const scale = 1.5;
                    const viewport = page.getViewport({ scale: scale });

                    const canvas = document.getElementById('pdf-canvas');
                    const context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    page.render(renderContext);
                });
            });
        };
        fileReader.readAsArrayBuffer(blob);
    })
    .catch(err => {
        alert('Gagal menampilkan PDF. Mungkin file rusak atau akses diblok.');
        console.error(err);
    });
</script>
@endsection
