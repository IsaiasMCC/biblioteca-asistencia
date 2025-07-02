@extends('layouts.app')

@push('title', 'Reporte por Roles')

@section('content_header')
    <h2>Reporte de Ingresos por Rol</h2>
@endsection

@section('content')
    <form method="GET" action="{{ route('reportes.ingresos') }}">
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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Rol</th>
                <th>Total Ingresos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ingresosPorRol as $rol => $datos)
                <tr>
                    <td>{{ $rol }}</td>
                    <td>{{ $datos['total_ingresos'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
