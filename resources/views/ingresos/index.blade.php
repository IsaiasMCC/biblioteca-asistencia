@extends('layouts.app')

@push('title', 'Ingresos')

@section('content_header')
    <h2>Escanear Ingreso / Salida</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('credenciales.index') }}">Credenciales</a></li>
        <li class="breadcrumb-item active">Escanear</li>
    </ol>
@endsection

@push('styles')
    <style>
        #reader {
            width: 100%;
            max-width: 400px;
            margin: auto;
        }

        .result-container {
            margin-top: 20px;
            text-align: center;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        const successAudio = new Audio('{{ asset('sounds/success.mp3') }}');
        const errorAudio = new Audio('{{ asset('sounds/error.mp3') }}');

        let html5QrCode;
        let scannerPaused = false;

        function onScanSuccess(decodedText) {
            if (scannerPaused) return;

            scannerPaused = true;

            fetch(`{{ url('verificar-credencial') }}/${decodedText}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        successAudio.play();
                        toastr.success(data.message, '✅ Acceso permitido');
                    } else {
                        errorAudio.play();
                        toastr.error(data.message, '❌ Acceso denegado');
                    }
                })
                .catch()
                .finally(() => {
                    setTimeout(() => {
                        scannerPaused = false;
                    }, 4000);
                });
        }

        $(document).ready(function() {
            html5QrCode = new Html5Qrcode("reader");

            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    const cameraId = devices[0].id;

                    html5QrCode.start(
                        cameraId, {
                            fps: 10,
                            qrbox: 250
                        },
                        onScanSuccess,
                    ).catch(err => {
                        toastr.error("No se pudo iniciar la cámara");
                    });
                }
            });
        });
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="reader"></div>
            <div class="result-container" id="result"></div>
        </div>
    </div>
@endsection
