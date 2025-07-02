<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\Credencial;
use App\Models\Sala;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index()
    {
        return view('asistencias.index');
    }

    public function verificar($codigo)
    {
        $credencial = Credencial::where('codigo', $codigo)->first();
        $sala = Sala::all()->first();
        if (!$credencial) {
            return response()->json([
                'success' => false,
                'message' => 'Credencial no encontrada'
            ]);
        }

        $hoy = Carbon::today();

        if (!$credencial->estado) {
            return response()->json([
                'success' => false,
                'message' => 'Credencial inactiva'
            ]);
        }

        if ($hoy->lt(Carbon::parse($credencial->fecha_emicion)) || $hoy->gt(Carbon::parse($credencial->fecha_expiracion))) {
            return response()->json([
                'success' => false,
                'message' => 'Credencial vencida'
            ]);
        }

        $now = Carbon::now();
        $fecha = $now->format('Y-m-d');
        $hora = $now->format('H:i:s');

        Asistencia::create([
            'hora' => $hora,
            'fecha' => $fecha,
            'credencial_id' => $credencial->id,
            'sala_id' => $sala->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Asistencia registrada',
            'usuario' => [
                'nombre' => $credencial->usuario->nombres . ' ' . $credencial->usuario->apellidos,
            ]
        ]);
    }

    public function reporteAsistencia(Request $request)
    {
        $fechaInicio = $request->fecha_inicial ? Carbon::parse($request->fecha_inicial)->startOfDay() : null;
        $fechaFin = $request->fecha_fin ? Carbon::parse($request->fecha_fin)->endOfDay() : null;

        $asistencias = Asistencia::with(['credencial.usuario']);

        if ($fechaInicio && $fechaFin) {
            $asistencias->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        } elseif ($fechaInicio) {
            $asistencias->where('fecha', '>=', $fechaInicio);
        } elseif ($fechaFin) {
            $asistencias->where('fecha', '<=', $fechaFin);
        }

        // Agrupar por estudiante y contar asistencias
        $asistenciaPorUsuario = $asistencias->get()
            ->groupBy(fn($a) => $a->credencial->usuario->id ?? null)
            ->map(function ($grupo) {
                $estudiante = $grupo->first()->credencial->usuario ?? null;
                return [
                    'ci' => $estudiante->ci,
                    'nombre' => $estudiante->nombres . ' ' . $estudiante->apellidos,
                    'rol' => $estudiante->role?->name,
                    'total_asistencias' => $grupo->count(),
                ];
            })->filter();

        return view('reportes.asistencias', [
            'asistencias' => $asistenciaPorUsuario,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
        ]);
    }
}
