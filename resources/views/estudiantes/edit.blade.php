@extends('layouts.app')

@push('title', 'Estudiantes')

@section('content_header')
    <h2> Editar Estudiante </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('estudiantes.index') }}">Estudiantes</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
@endsection

@push('scripts')
    <script src="{{ asset('js/platillos/edit.js') }}"></script>
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
                <form action="{{ route('estudiantes.update', $estudiante->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="registro">Registro</label>
                        <input type="text" name="registro" class="form-control @error('registro') is-invalid @enderror"
                            value="{{ old('registro', $estudiante->registro) }}">
                        @error('registro')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                            value="{{ old('telefono', $estudiante->telefono) }}">
                        @error('telefono')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $estudiante->email) }}">
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="codigo_carrera">Código de Carrera</label>
                        <input type="text" name="codigo_carrera"
                            class="form-control @error('codigo_carrera') is-invalid @enderror"
                            value="{{ old('codigo_carrera', $estudiante->codigo_carrera) }}">
                        @error('codigo_carrera')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="carrera">Carrera</label>
                        <input type="text" name="carrera" class="form-control @error('carrera') is-invalid @enderror"
                            value="{{ old('carrera', $estudiante->carrera) }}">
                        @error('carrera')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="genero">Género</label>
                        <select name="genero" class="form-control @error('genero') is-invalid @enderror">
                            <option value="" disabled>Seleccione una opción</option>
                            <option value="masculino"
                                {{ old('genero', $estudiante->genero) === 'masculino' ? 'selected' : '' }}>Masculino
                            </option>
                            <option value="femenino"
                                {{ old('genero', $estudiante->genero) === 'femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="otro" {{ old('genero', $estudiante->genero) === 'otro' ? 'selected' : '' }}>
                                Otro</option>
                        </select>
                        @error('genero')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <input type="hidden" name="remove_image" id="remove_image" value="0">
                    <div class="form-group mx-3" id="image-before">
                        <label for="image" class="form-label"> Foto (opcional)</label>
                        <label id="labeldefault" class="tex form-label row ml-2 border col-3"
                            style="height: 150px; {{ $estudiante->foto_url ? 'display: none;' : 'flex;' }} justify-content: center; align-items: center; position: relative;">
                            <i id="icono" class="fa fa-file-image-o" aria-hidden="true" style="font-size: 3rem;"></i>
                            <input type="file" id="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                                name="foto_url" class="form-control d-none">
                        </label>
                        @if ($estudiante->foto_url)
                            <div class="form-group mx-3" id="imagePreview">
                                <img id="preview" class="img-thumbnail" style="max-width: 300px; max-height: 300px;"
                                    src="{{ asset('storage/students/' . $estudiante->foto_url) }}">
                                <div class="mt-2">
                                    <button type="button" id="removeImage" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> Quitar
                                    </button>
                                </div>
                            </div>
                        @else
                            @error('foto_url')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-group mx-3" id="imagePreview" style="display: none;">
                                <img id="preview" class="img-thumbnail" style="max-width: 300px; max-height: 300px;">
                                <div class="mt-2">
                                    <button type="button" id="removeImage" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> Quitar
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="user_id">Usuario Asignado</label>
                        <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                            <option value="" disabled>Seleccione un usuario</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $estudiante->user_id) == $user->id ? 'selected' : '' }}>
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
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
