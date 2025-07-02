@extends('layouts.app')

@push('title', 'Horarios')

@section('content_header')
    <h2>Agregar Horario</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('horarios.index') }}">Horarios</a></li>
        <li class="breadcrumb-item active">Crear</li>
    </ol>
@endsection

@push('styles')
    {{-- <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet"> --}}
@endpush

@push('scripts')
    {{-- <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            @if ($errors->any())
                toastr.error('Hay errores en el formulario', 'Error');
            @endif
        });
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('horarios.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="col-sm-2 col-form-label">Días</label>
                    <div class="col-sm-10">
                        @php
                            $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
                        @endphp

                        @foreach ($dias as $dia)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="{{ $dia }}"
                                    id="{{ $dia }}" value="1" {{ old($dia) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $dia }}">{{ ucfirst($dia) }}</label>
                            </div>
                        @endforeach

                        @foreach ($dias as $dia)
                            @error($dia)
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label for="hora_inicio" class="col-sm-2 col-form-label">Hora Inicio</label>
                    <div class="col-sm-4">
                        <input type="time" class="form-control" name="hora_inicio" id="hora_inicio"
                            value="{{ old('hora_inicio') }}" required>
                        @error('hora_inicio')
                            <div class="text-danger"><small>{{ $message }}</small></div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="hora_fin" class="col-sm-2 col-form-label">Hora Fin</label>
                    <div class="col-sm-4">
                        <input type="time" class="form-control" name="hora_fin" id="hora_fin"
                            value="{{ old('hora_fin') }}" required>
                        @error('hora_fin')
                            <div class="text-danger"><small>{{ $message }}</small></div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="sala_id" class="col-sm-2 col-form-label"> Sala </label>
                    <select name="sala_id" id="sala_id"
                        class="ml-3 custom-select single-select @error('sala_id') is-invalid @enderror">
                        <option value="" selected disabled> Seleccione una opción </option>
                        @foreach ($salas as $sala)
                            <option value="{{ $sala->id }}" {{ old('sala_id') == $sala->id ? 'selected' : '' }}>
                                {{ $sala->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('sala_id')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group row ">
                    <div class="col-sm-12 ml-3">
                        <a href="{{ route('horarios.index') }}" class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
