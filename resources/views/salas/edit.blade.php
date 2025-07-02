@extends('layouts.app')

@push('title', 'Salas')

@section('content_header')
    <h2> Editar Sala </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"> <a href={{ route('salas.index') }}> Inicio </a> </li>
        <li class="breadcrumb-item active"> <a href='#'> Editar </a> </li>
    </ol>
@endsection

@push('styles')
    <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.single-select').select2();
            toastr.options = {
                positionClass: "toast-top-right",
                timeOut: 2000,
                progressBar: true,
            };

            @if ($errors->any())
                toastr.warning("Validaciones Incorrectas", 'Warning');
            @endif

            @if (session('error'))
                toastr.error(@json(session('error')), 'Error');
            @endif
        });
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action="{{ route('salas.update', $sala->id) }}">
                @csrf
                @method('PATCH')
               
                <div class="form-group">
                    <label for="nombre" class="input-label">Nombre </label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                        aria-describedby="nombre" name="nombre" value="{{ $sala->nombre }}">
                    @error('nombre')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="capacidad" class="input-label">Capacidad </label>
                    <input type="text" class="form-control @error('capacidad') is-invalid @enderror" id="capacidad"
                        aria-describedby="capacidad" name="capacidad" value="{{ $sala->capacidad }}">
                    @error('capacidad')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="ubicacion" class="input-label">Ubicación </label>
                    <input type="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror" id="ubicacion"
                        aria-describedby="ubicacion" name="ubicacion" value="{{ $sala->ubicacion }}">
                    @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="custom-select single-select">
                        <option value="1" {{ $sala->estado == 1 ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ $sala->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <a href="{{ route('salas.index') }}" type="button" class="btn btn-danger">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>
@endsection
