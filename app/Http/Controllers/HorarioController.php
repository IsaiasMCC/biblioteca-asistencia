<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\horarios\StoreHorarioRequest;
use App\Http\Requests\horarios\UpdateHorarioRequest;
use App\Http\Requests\salas\UpdateSalaRequest;
use App\Models\Horario;
use App\Models\Sala;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $horarios = Horario::all();
        return view('horarios.index', compact('horarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $salas = Sala::all();
        return view('horarios.create', compact('salas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHorarioRequest $request)
    {
        // dd($request);
        $data = $request->validated();
        try {
            Horario::create([
                'lunes' => $request->has('lunes'),
                'martes' => $request->has('martes'),
                'miercoles' => $request->has('miercoles'),
                'jueves' => $request->has('jueves'),
                'viernes' => $request->has('viernes'),
                'sabado' => $request->has('sabado'),
                'domingo' => $request->has('domingo'),
                'hora_inicio' => $request->hora_inicio,
                'hora_fin' => $request->hora_fin,
                'sala_id' => $data['sala_id']
            ]);
            return redirect()->route('horarios.index')->with('success', 'Horario creado correctamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Error al crear horario: ' . $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $salas = Sala::all();
        $horario = Horario::findOrFail($id);
        return view('horarios.edit', compact('horario', 'salas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHorarioRequest $request, string $id)
    {
        $data = $request->validated();
        try {
            $horario = Horario::findOrFail($id);
            $horario->update([
                'lunes' => $request->has('lunes'),
                'martes' => $request->has('martes'),
                'miercoles' => $request->has('miercoles'),
                'jueves' => $request->has('jueves'),
                'viernes' => $request->has('viernes'),
                'sabado' => $request->has('sabado'),
                'domingo' => $request->has('domingo'),
                'hora_inicio' => $request->hora_inicio,
                'hora_fin' => $request->hora_fin,
                'sala_id' => $data['sala_id']
            ]);
            return redirect()->route('horarios.index')->with('success', 'Horario actualizado correctamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Error al actualizar horario: ' . $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $horario = Horario::findOrFail($id);
        try {
            $horario->delete();
            return response()->json([
                'success' => true,
                'message' => 'Horario eliminado correctamente.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar horario: ' . $th->getMessage()
            ], 500);
        }
    }
}
