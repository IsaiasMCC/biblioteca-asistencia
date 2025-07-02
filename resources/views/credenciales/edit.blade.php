@extends('layouts.app')

@push('title', 'Credenciales')

@section('content_header')
    <h2>Editar Credencial</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('credenciales.index') }}">Credenciales</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Mostrar errores si hay
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error(@json($error), 'Error de validación');
                @endforeach
            @endif

            // Autoactualizar fecha de expiración al cambiar emisión
            $('#fecha_emicion').on('change', function() {
                let emision = new Date(this.value);
                if (!isNaN(emision.getTime())) {
                    let expiracion = new Date(emision);
                    expiracion.setFullYear(expiracion.getFullYear() + 1);
                    document.getElementById('fecha_expiracion').value = expiracion.toISOString().split('T')[
                        0];
                }
            });
        });
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content style-tema">
                <form action="{{ route('credenciales.update', $credencial->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="codigo">Código</label>
                        <input type="text" class="form-control" name="codigo" value="{{ $credencial->codigo }}"
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="fecha_emicion">Fecha de Emisión</label>
                        <input type="date" name="fecha_emicion" id="fecha_emicion"
                            class="form-control @error('fecha_emicion') is-invalid @enderror"
                            value="{{ old('fecha_emicion', $credencial->fecha_emicion) }}">
                        @error('fecha_emicion')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_expiracion">Fecha de Expiración</label>
                        <input type="date" id="fecha_expiracion" name="fecha_expiracion"
                            class="form-control @error('fecha_expiracion') is-invalid @enderror"
                            value="{{ old('fecha_expiracion', $credencial->fecha_expiracion) }}" readonly>
                        @error('fecha_expiracion')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="estudiante_id">Usuario</label>
                        <input type="text" class="form-control" readonly
                            value="{{ $credencial->usuario->ci }} - {{ $credencial->usuario->nombres }} {{ $credencial->usuario->apellidos }} - {{ $credencial->usuario->role->name }}">
                    </div>
                    <div class="form-group">
                        <label for="gestion_id">Gestión</label>
                        <input type="text" class="form-control" readonly
                            value="{{ $credencial->gestion->anio }} - {{ $credencial->gestion->semestre }}">
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select name="estado" class="form-control">
                            <option value="1" {{ $credencial->estado ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !$credencial->estado ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <a href="{{ route('credenciales.index') }}" class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
