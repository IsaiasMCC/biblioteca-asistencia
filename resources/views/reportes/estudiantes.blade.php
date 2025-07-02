@extends('layouts.app')

@push('title', 'Asistencia por Usuario')

@section('content_header')
    <h2>Reporte de Estudiantes</h2>
@endsection

@section('content')
    <form method="GET" action="{{ route('reportes.asistencias') }}">
        <div class="row">
            <div class="col-md-4">
                <label>Fecha Inicial</label>
                <input type="date" name="fecha_inicial" class="form-control" value="{{ request('fecha_inicial') }}">
            </div>
            <div class="col-md-4">
                <label>Fecha Final</label>
                <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
            </div>
            <div class="col-md-4 mt-4">
                <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
            </div>
        </div>
    </form>

    <hr>

    {{-- @if (isset($asistencias->count())) --}}
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>CI</th>
                    <th>Nombre</th>
                    <th>Rol</th>
                    <th>Estudiante</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($asistencias as $item)
                    <tr>
                        <td>{{ $item['ci'] }}</td>
                        <td>{{ $item['nombre'] }}</td>
                        <td>{{ $item['rol'] }}</td>
                        <td><strong>{{ $item['total_asistencias'] }}</strong></td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
    {{-- @else
        <div class="alert alert-warning mt-4">No hay asistencias para mostrar.</div>
    @endif --}}
@endsection
