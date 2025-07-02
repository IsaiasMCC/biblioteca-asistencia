<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\estudiantes\StoreEstudianteRequest;
use App\Http\Requests\estudiantes\UpdateEstudianteRequest;
use App\Models\Estudiante;
use App\Models\User;
use App\Traits\ImageHandlerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EstudianteController extends Controller
{
    use ImageHandlerTrait;
    public function index()
    {
        $students = Estudiante::all();
        return view('estudiantes.index', compact('students'));
    }

    public function create()
    {
        $users = User::all();
        return view('estudiantes.create', compact('users'));
    }

    public function edit(string $id)
    {
        $users = User::all();
        $estudiante = Estudiante::findOrFail($id);
        return view('estudiantes.edit', compact('estudiante', 'users'));
    }

    public function store(StoreEstudianteRequest $request)
    {
        $data = $request->validated();
        try {
            if ($request->hasFile('foto_url')) {
                $img = $request->file('foto_url');
                $imageName = $this->storeImage($img);
                $data['foto_url'] = $imageName;
            }
            Estudiante::create($data);
            return redirect()->route('estudiantes.index')->with('success', 'Estudiante creado correctamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Error al crear Estudiante' . $th->getMessage());
        }
    }

    public function update(UpdateEstudianteRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $student = Estudiante::findOrFail($id);

            // Si el usuario subió una nueva imagen
            if ($request->hasFile('foto_url')) {
                // Eliminar la imagen anterior si existe
                if ($student->foto_url && Storage::disk('public')->exists('students/' . $student->foto_url)) {
                    $this->deleteImage($student->foto_url);
                }

                // Guardar la nueva imagen
                $img = $request->file('foto_url');
                $imageName = $this->storeImage($img); // asegúrate de que devuelva solo el nombre
                $data['foto_url'] = $imageName;
            }

            // Si no se sube una nueva imagen, verificar si se eliminó desde el frontend
            if ($request->has('remove_image') && $student->foto_url) {
                if (Storage::disk('public')->exists('students/' . $student->foto_url)) {
                    $this->deleteImage($student->foto_url);
                }
                $data['foto_url'] = null;
            }

            $student->update($data);

            return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado correctamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar Estudiante: ' . $th->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $student = Estudiante::findOrFail($id);
        try {
            $student->delete();
            return response()->json([
                'success' => true,
                'message' => 'Estudienate eliminado correctamente.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar estudiante: ' . $th->getMessage()
            ], 500);
        }
    }

    public function reporteEstudiantes(Request $request)
    {
        $asistencias = [];
        return view('reportes.estudiantes', compact('asistencias'));
    }
}
