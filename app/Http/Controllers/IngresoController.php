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
        $sala = Sala::all()->first();
        if (!$credencial) {
            return response()->json([
                'success' => false,
                'message' => 'Credencial no encontrada'
            ], 404);
        }

        $hoy = Carbon::today();

        if (!$credencial->estado) {
            return response()->json([
                'success' => false,
                'message' => 'Credencial inactiva'
            ], 404);
        }

        if ($hoy->lt(Carbon::parse($credencial->fecha_emicion)) || $hoy->gt(Carbon::parse($credencial->fecha_expiracion))) {
            return response()->json([
                'success' => false,
                'message' => 'Credencial vencida'
            ], 404);
        }


        // Asumimos que ya tienes la credencial_id y sala_id
        $credencialId = $credencial->id;
        $salaId = $sala->id;
        $now = Carbon::now();

        $fecha = $now->format('Y-m-d');
        $hora = $now->format('H:i:s');

        // Obtener último ingreso o salida
        $ultimoIngreso = Ingreso::where('credencial_id', $credencialId)
            ->where('sala_id', $salaId)
            ->latest()
            ->first();

        $ultimoSalida = Salida::where('credencial_id', $credencialId)
            ->where('sala_id', $salaId)
            ->latest()
            ->first();

        // Determinar si fue ingreso o salida más reciente
        if (!$ultimoIngreso && !$ultimoSalida) {
            // ✅ Primer acceso, registrar ingreso
            Ingreso::create([
                'hora' => $hora,
                'fecha' => $fecha,
                'credencial_id' => $credencialId,
                'sala_id' => $salaId
            ]);
            $mensaje = "Ingreso registrado";
        } elseif ($ultimoIngreso && (!$ultimoSalida || $ultimoIngreso->created_at > $ultimoSalida->created_at)) {
            // ✅ Último fue ingreso → ahora registrar salida
            Salida::create([
                'hora' => $hora,
                'fecha' => $fecha,
                'credencial_id' => $credencialId,
                'sala_id' => $salaId
            ]);
            $mensaje = "Salida registrada";
        } else {
            // ✅ Último fue salida → ahora registrar ingreso
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
            'message' => 'Acceso permitido',
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
