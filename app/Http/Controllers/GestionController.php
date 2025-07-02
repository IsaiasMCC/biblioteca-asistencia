<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\gestiones\StoreGestionRequest;
use App\Http\Requests\gestiones\UpdateGestionRequest;
use App\Models\Gestion;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gestions = Gestion::all();
        return view('gestiones.index', compact('gestions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gestiones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGestionRequest $request)
    {
        $data = $request->validated();
        try {
            Gestion::create($data);
            return redirect()->route('gestiones.index')->with('success', 'Gestión creada correctamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Error al crear gestión' . $th->getMessage());
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
        $gestion = Gestion::findOrFail($id);
        return view('gestiones.edit', compact('gestion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGestionRequest $request, string $id)
    {
        $data = $request->validated();
        try {
            $gestion = Gestion::findOrFail($id);
            $gestion->update($data);
            return redirect()->route('gestiones.index')->with('success', 'Gestion creada correctamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar gestion' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gestion = Gestion::findOrFail($id);
        try {
            $gestion->delete();
            return response()->json([
                'success' => true,
                'message' => 'Gestión eliminado correctamente.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar gestión: ' . $th->getMessage()
            ], 500);
        }
    }
}
