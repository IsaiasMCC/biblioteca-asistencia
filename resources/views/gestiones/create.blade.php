@extends('layouts.app')

@push('title', 'Gestiones')

@section('content_header')
    <h2> Agregar Gestión </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"> <a href={{ route('gestiones.index') }}> Inicio </a> </li>
        <li class="breadcrumb-item active"> <a href={{ route('gestiones.create') }}> Agregar </a> </li>
    </ol>
@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
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
            <div class="ibox-content style-tema">
                <form method="POST" action="{{ route('gestiones.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="anio" class="input-label">Año </label>
                        <input type="text" class="form-control @error('anio') is-invalid @enderror" id="anio"
                            aria-describedby="anio" name="anio" value="{{ old('anio') }}">
                        @error('anio')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="semestre" class="input-label">Semestre </label>
                        <input type="text" class="form-control @error('semestre') is-invalid @enderror" id="semestre"
                            aria-describedby="semestre" name="semestre" value="{{ old('semestre') }}">
                        @error('semestre')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <a href="{{ route('gestiones.index') }}" type="button" class="btn btn-danger">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>

@endsection
