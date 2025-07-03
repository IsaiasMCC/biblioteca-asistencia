@extends('layouts.app')

@push('title', 'Asistencia por Usuario')

@section('content_header')
    <h2>Reporte de Estudiantes</h2>
@endsection

@section('content')
    <form method="GET" action="{{ route('reportes.estudiantes') }}">
        <div class="row">
            <div class="col-md-4">
                <label>Fecha Inicial</label>
                <input type="date" name="fecha_inicial" class="form-control" value="{{ request('fecha_inicio') }}">
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

    <h2>Reporte de Ingresos por Estudiante</h2>

    @if ($fechaInicio && $fechaFin)
        <p>Desde: {{ $fechaInicio }} | Hasta: {{ $fechaFin }}</p>
    @elseif($fechaInicio)
        <p>Desde: {{ $fechaInicio }}</p>
    @elseif($fechaFin)
        <p>Hasta: {{ $fechaFin }}</p>
    @endif

    @forelse($ingresos as $estudianteId => $grupo)
        @php
            $usuario = $grupo->first()->credencial->usuario;
            $estudiante = $usuario->estudiante;
        @endphp

        <h3>{{ $usuario->nombres }} {{ $usuario->apellidos }} (CI: {{ $usuario->ci }})</h3>
        <p>Total ingresos: {{ $grupo->count() }}</p>

        <table border="1" cellpadding="5">
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Hora</th>
            </tr>
            @foreach ($grupo as $i => $ingreso)
                @php
                    $fecha = $ingreso->created_at ? \Carbon\Carbon::parse($ingreso->created_at) : null;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $fecha ? $fecha->format('Y-m-d') : '—' }}</td>
                    <td>{{ $fecha ? $fecha->format('H:i:s') : '—' }}</td>
                </tr>
            @endforeach
        </table>
        <br>
    @empty
        <p>No hay ingresos registrados en el rango indicado.</p>
    @endforelse
    <h2>Reporte de Salidas por Estudiante</h2>
    @forelse($salidas as $estudianteId => $grupo)
        @php
            $usuario = $grupo->first()->credencial->usuario;
            $estudiante = $usuario->estudiante;
        @endphp

        <h3>{{ $usuario->nombres }} {{ $usuario->apellidos }} (CI: {{ $usuario->ci }})</h3>
        <p>Total Salidas: {{ $grupo->count() }}</p>

        <table border="1" cellpadding="5">
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Hora</th>
            </tr>
            @foreach ($grupo as $i => $salida)
                @php
                    $fecha = $salida->created_at ? \Carbon\Carbon::parse($salida->created_at) : null;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $fecha ? $fecha->format('Y-m-d') : '—' }}</td>
                    <td>{{ $fecha ? $fecha->format('H:i:s') : '—' }}</td>
                </tr>
            @endforeach
        </table>
        <br>
    @empty
        <p>No hay salidas registrados en el rango indicado.</p>
    @endforelse

@endsection
