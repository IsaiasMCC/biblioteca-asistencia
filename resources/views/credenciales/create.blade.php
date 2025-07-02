@extends('layouts.app')

@push('title', 'Credenciales')

@section('content_header')
    <h2>Agregar Credencial</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('credenciales.index') }}">Credenciales</a></li>
        <li class="breadcrumb-item active">Agregar</li>
    </ol>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error(@json($error), 'Error de validación');
                @endforeach
            @endif
        });
    </script>
@endpush
@php
    $codigo = Str::upper(Str::random(8));
    $fechaHoy = \Carbon\Carbon::now()->format('Y-m-d');
    $fechaExp = \Carbon\Carbon::now()->addYear()->format('Y-m-d');
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content style-tema">
                <form action="{{ route('credenciales.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="codigo">Código</label>
                        <input type="text" name="codigo" class="form-control @error('codigo') is-invalid @enderror"
                            value="{{ old('codigo', $codigo) }}" readonly>
                        @error('codigo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_emicion">Fecha de Emisión</label>
                        <input type="date" name="fecha_emicion"
                            class="form-control @error('fecha_emicion') is-invalid @enderror"
                            value="{{ old('fecha_emicion', $fechaHoy) }}" readonly>
                        @error('fecha_emicion')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_expiracion">Fecha de Expiración</label>
                        <input type="date" name="fecha_expiracion"
                            class="form-control @error('fecha_expiracion') is-invalid @enderror"
                            value="{{ old('fecha_expiracion', $fechaExp) }}" readonly>
                        @error('fecha_expiracion')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="usuario_id">Usuario </label>
                        <select name="usuario_id" class="form-control @error('usuario_id') is-invalid @enderror">
                            <option value="" disabled selected>Seleccione un usuario</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}"
                                    {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->ci }} - {{ $usuario->role->name }} - {{ $usuario->nombres }} {{ $usuario->apellidos}}
                                    
                                </option>
                            @endforeach
                        </select>
                        @error('usuario_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="gestion_id">Gestión</label>
                        <select name="gestion_id" class="form-control @error('gestion_id') is-invalid @enderror">
                            <option value="" disabled selected>Seleccione una gestión</option>
                            @foreach ($gestiones as $gestion)
                                <option value="{{ $gestion->id }}"
                                    {{ old('gestion_id') == $gestion->id ? 'selected' : '' }}>
                                    {{ $gestion->anio }} - {{ $gestion->semestre }}
                                </option>
                            @endforeach
                        </select>
                        @error('gestion_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select name="estado" class="form-control @error('estado') is-invalid @enderror">
                            <option value="1" {{ old('estado', '1') == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <a href="{{ route('credenciales.index') }}" class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
