<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Credencial;
use App\Models\Ingreso;
use App\Models\Sala;
use App\Models\Salida;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ingresos.index');
    }

    public function verificar($codigo)
    {
        $credencial = Credencial::where('codigo', $codigo)->first();
        $sala = Sala::first();

        if (!$credencial) {
            return response()->json([
                'success' => false,
                'message' => 'Credencial no encontrada'
            ], 404);
        }

        if (!$credencial->estado) {
            return response()->json([
                'success' => false,
                'message' => 'Credencial inactiva'
            ], 403);
        }

        $hoy = Carbon::today();

        if ($hoy->lt(Carbon::parse($credencial->fecha_emicion)) || $hoy->gt(Carbon::parse($credencial->fecha_expiracion))) {
            return response()->json([
                'success' => false,
                'message' => 'Credencial vencida'
            ], 403);
        }

        $credencialId = $credencial->id;
        $salaId = $sala->id;
        $now = Carbon::now();
        $fecha = $now->format('Y-m-d');
        $hora = $now->format('H:i:s');

        $ultimoIngreso = Ingreso::where('credencial_id', $credencialId)
            ->where('sala_id', $salaId)
            ->orderBy('created_at', 'desc')
            ->first();

        $ultimoSalida = Salida::where('credencial_id', $credencialId)
            ->where('sala_id', $salaId)
            ->orderBy('created_at', 'desc')
            ->first();

        // Verificar si no hay ningún registro anterior
        if (!$ultimoIngreso && !$ultimoSalida) {
            Ingreso::create([
                'hora' => $hora,
                'fecha' => $fecha,
                'credencial_id' => $credencialId,
                'sala_id' => $salaId
            ]);
            $mensaje = "Ingreso registrado";
        }
        // Si el último fue ingreso y es más reciente que la última salida
        elseif ($ultimoIngreso && (
            !$ultimoSalida || (
                $ultimoIngreso->created_at &&
                $ultimoSalida->created_at &&
                $ultimoIngreso->created_at->gt($ultimoSalida->created_at)
            )
        )) {
            Salida::create([
                'hora' => $hora,
                'fecha' => $fecha,
                'credencial_id' => $credencialId,
                'sala_id' => $salaId
            ]);
            $mensaje = "Salida registrada";
        }
        // En cualquier otro caso, registrar ingreso
        else {
            Ingreso::create([
                'hora' => $hora,
                'fecha' => $fecha,
                'credencial_id' => $credencialId,
                'sala_id' => $salaId
            ]);
            $mensaje = "Ingreso registrado";
        }

        return response()->json([
            'success' => true,
            'message' => $mensaje,
            'usuario' => [
                'nombre' => $credencial->usuario->nombres . ' ' . $credencial->usuario->apellidos,
            ]
        ]);
    }



    public function reporteIngresos(Request $request)
    {
        $fechaInicio = $request->fecha_inicial ? Carbon::parse($request->fecha_inicial)->startOfDay() : null;
        $fechaFin = $request->fecha_fin ? Carbon::parse($request->fecha_fin)->endOfDay() : null;

        $ingresos = Ingreso::with(['credencial.usuario.role']);

        if ($fechaInicio && $fechaFin) {
            $ingresos->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        } elseif ($fechaInicio) {
            $ingresos->where('fecha', '>=', $fechaInicio);
        } elseif ($fechaFin) {
            $ingresos->where('fecha', '<=', $fechaFin);
        }

        $ingresos = $ingresos->get();

        // Agrupar por rol
        $ingresosPorRol = $ingresos->groupBy(function ($ingreso) {
            return optional($ingreso->credencial->usuario->role)->name ?? 'Sin rol';
        })->map(function ($grupo) {
            return [
                'total_ingresos' => $grupo->count(),
            ];
        });

        return view('reportes.ingresos', [
            'ingresosPorRol' => $ingresosPorRol,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
        ]);
    }
}
