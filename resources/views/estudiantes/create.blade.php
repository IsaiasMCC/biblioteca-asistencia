@extends('layouts.app')

@push('title', 'Estudiantes')

@section('content_header')
    <h2> Agregar Estudiante </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('estudiantes.index') }}">Estudiantes</a></li>
        <li class="breadcrumb-item active">Agregar</li>
    </ol>
@endsection

@push('scripts')
    <script src="{{ asset('js/platillos/create.js') }}"></script>
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

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content style-tema">
                <form action="{{ route('estudiantes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="registro">Registro</label>
                        <input type="text" name="registro" class="form-control @error('registro') is-invalid @enderror"
                            value="{{ old('registro') }}">
                        @error('registro')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                            value="{{ old('telefono') }}">
                        @error('telefono')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="codigo_carrera">Código de Carrera</label>
                        <input type="text" name="codigo_carrera"
                            class="form-control @error('codigo_carrera') is-invalid @enderror"
                            value="{{ old('codigo_carrera') }}">
                        @error('codigo_carrera')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="carrera">Carrera</label>
                        <input type="text" name="carrera" class="form-control @error('carrera') is-invalid @enderror"
                            value="{{ old('carrera') }}">
                        @error('carrera')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="genero">Género</label>
                        <select name="genero" class="form-control @error('genero') is-invalid @enderror">
                            <option value="" disabled {{ old('genero') === null ? 'selected' : '' }}>Seleccione una
                                opción</option>
                            <option value="masculino" {{ old('genero') === 'masculino' ? 'selected' : '' }}>Masculino
                            </option>
                            <option value="femenino" {{ old('genero') === 'femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="otro" {{ old('genero') === 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('genero')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="foto_url">Foto (opcional)</label>
                        <input id="foto_url" type="file" name="foto_url"
                            class="form-control @error('foto_url') is-invalid @enderror"
                            accept="image/jpeg,image/png,image/jpg,image/webp">
                        @error('foto_url')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Contenedor para la previsualización de la imagen -->
                    <div class="form-group" id="imagePreview" style="display: none;">
                        <!-- Imagen que se previsualiza después de cargar -->
                        <img id="preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                        <div class="mt-2">
                            <button type="button" id="removeImage" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Quitar
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="user_id">Usuario Asignado</label>
                        <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                            <option value="" disabled {{ old('user_id') === null ? 'selected' : '' }}>Seleccione un
                                usuario</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->nombres }} ({{ $user->apellidos }}) - {{ $user->ci }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <a href="{{ route('estudiantes.index') }}" class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
