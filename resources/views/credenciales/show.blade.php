@extends('layouts.app')

@push('title', 'Credencial')

@section('content_header')
    <h2>Credencial de Acceso</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('credenciales.index') }}">Credenciales</a></li>
        <li class="breadcrumb-item active">Carnet</li>
    </ol>
@endsection

@push('styles')
    <style>
        .carnet-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 40px;
        }

        .card-face {
            width: 400px;
            height: 220px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            position: relative;
            font-family: 'Segoe UI', sans-serif;
            padding: 20px;
        }

        .card-front {
            background-color: #cccccc;
            color: #000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
        }

        .card-front h4 {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .info-block {
            display: flex;
            gap: 15px;
        }

        .info-text {
            flex-grow: 1;
            font-size: 14px;
        }

        .info-text div {
            margin-bottom: 5px;
        }

        .photo {
            width: 100px;
            height: 120px;
            background-color: #ccc;
            border-radius: 5px;
            overflow: hidden;
        }

        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .barcode {
            margin-top: 10px;
            text-align: center;
            font-size: 12px;
        }

        .card-back {
            background-color: #f2f2f2;
            color: #333;
            text-align: center;
        }

        .qr-container img {
            width: 120px;
            height: 120px;
            object-fit: contain;
        }

        .instructions {
            font-size: 12px;
            margin-top: 10px;
            color: #555;
        }
    </style>
@endpush

@section('content')
    <div class="carnet-container">

        {{-- ANVERSO --}}
        @if (optional($credencial->usuario)->estudiante)
            <div class="card-face card-front">
                <h4>Credencial Biblioteca FICCT</h4>
                <div class="info-block">
                    <div class="photo">
                        @if (isset($credencial->usuario->estudiante) && isset($credencial->usuario->estudiante->foto_url))
                            <img src="{{ asset('storage/students/' . $credencial->usuario->estudiante->foto_url) }}" alt="Foto">
                        @else
                            <img src="{{ asset('images/default-user.png') }}" alt="Foto genérica">
                        @endif
                    </div>
                    <div class="info-text">
                        <div>
                            <strong>{{ strtoupper($credencial->usuario->nombres . ' ' . $credencial->usuario->apellidos) }}</strong>
                        </div>
                        <div>Registro: {{ $credencial->usuario->estudiante->registro }}</div>
                        <div>Carrera: {{ $credencial->usuario->estudiante->carrera }}</div>
                        <div>Emitido: {{ \Carbon\Carbon::parse($credencial->fecha_emicion)->format('d/m/Y') }}</div>
                        <div>Expira: {{ \Carbon\Carbon::parse($credencial->fecha_expiracion)->format('d/m/Y') }}</div>
                    </div>
                </div>
                <div class="text-center font-bold">
                    {{ $credencial->codigo }}
                </div>
                <div class="barcode">
                    {{ $credencial->fot_qr }}<br>
                    {{-- Podrías usar una imagen si tienes librería para generar barcode --}}
                    {{-- <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($credencial->codigo, 'C39') }}"> --}}
                </div>
            </div>
        @else
            <div class="card-face card-front">
                <h4>Credencial Biblioteca FICCT</h4>
                <div class="info-block">
                    <div class="photo">
                            <img src="{{ asset('images/default-profile.jpg') }}" alt="Foto genérica">
                    </div>
                    <div class="info-text">
                        <div>
                            <strong>{{ strtoupper($credencial->usuario->nombres . ' ' . $credencial->usuario->apellidos) }}</strong>
                        </div>
                        <div>CI: {{ $credencial->usuario->ci }}</div>
                        <div>Cargo: {{ $credencial->usuario->role->name }}</div>
                        <div>Emitido: {{ \Carbon\Carbon::parse($credencial->fecha_emicion)->format('d/m/Y') }}</div>
                        <div>Expira: {{ \Carbon\Carbon::parse($credencial->fecha_expiracion)->format('d/m/Y') }}</div>
                    </div>
                </div>
                <div class="text-center font-bold">
                    {{ $credencial->codigo }}
                </div>
                <div class="barcode">
                    {{ $credencial->fot_qr }}<br>
                    {{-- Podrías usar una imagen si tienes librería para generar barcode --}}
                    {{-- <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($credencial->codigo, 'C39') }}"> --}}
                </div>
            </div>
        @endif
        



        {{-- REVERSO --}}
        <div class="card-face card-back">
            <h5>Acceso Digital</h5>

            <div class="qr-container mt-2">
                {!! QrCode::size(120)->generate($credencial->codigo) !!}
            </div>

            <div class="instructions mt-2">
                Escanee este código con su dispositivo móvil para validar esta credencial.<br>
                Si encuentra esta tarjeta, por favor devuélvala a la administración.
            </div>
        </div>

    </div>
@endsection
