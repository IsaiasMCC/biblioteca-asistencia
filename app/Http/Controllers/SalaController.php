<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\salas\StoreSalaRequest;
use App\Http\Requests\salas\UpdateSalaRequest;
use App\Models\Sala;
use Illuminate\Http\Request;

class SalaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salas = Sala::all();
        return view('salas.index', compact('salas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('salas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalaRequest $request)
    {
        $data = $request->validated();
        try {
            Sala::create($data);
            return redirect()->route('salas.index')->with('success', 'Sala creada Correctamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Error al crear sala: ' . $th->getMessage()]);
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
        $sala = Sala::findOrFail($id);
        return view('salas.edit', compact('sala'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalaRequest $request, string $id)
    {
        $data = $request->validated();
        try {
            $sala = Sala::findOrFail($id);
            $sala->update($data);
            return redirect()->route('salas.index')->with('success', 'Sala actualizada correctamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Error al actualizar sala: ' . $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sala = Sala::findOrFail($id);
        try {
            $sala->delete();
            return response()->json([
                'success' => true,
                'message' => 'Sala eliminada correctamente.',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar sala: ' . $th->getMessage(),
            ], 500);
        }
    }
}
