<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\credenciales\StoreCredencialRequest;
use App\Http\Requests\credenciales\UpdateCredencialRequest;
use App\Models\Credencial;
use App\Models\Estudiante;
use App\Models\Gestion;
use App\Models\User;
use Illuminate\Http\Request;

class CredencialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $credenciales = Credencial::all();
        return view('credenciales.index', compact('credenciales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::where('estado', true)->get();
        $gestiones = Gestion::all();
        return view('credenciales.create', compact('usuarios', 'gestiones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCredencialRequest $request)
    {
        $data = $request->validated();
        try {
            Credencial::create($data);
            return redirect()->route('credenciales.index')->with('success', 'Credencial creada correctamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Error al crear credencial' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $credencial = Credencial::findOrFail($id);
        return view('credenciales.show', compact('credencial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gestiones = Gestion::all();
        $credencial = Credencial::findOrFail($id);
        return view('credenciales.edit', compact('credencial', 'gestiones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCredencialRequest $request, string $id)
    {
        $data = $request->validated();
        try {
            $credencial = Credencial::findOrFail($id);
            $credencial->update($data);
            return redirect()->route('credenciales.index')->with('success', 'Credencial creada correctamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar credencial' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $credencial = Credencial::findOrFail($id);
        try {
            $credencial->delete();
            return response()->json([
                'success' => true,
                'message' => 'Credencial eliminado correctamente.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar credencial: ' . $th->getMessage()
            ], 500);
        }
    }
}
