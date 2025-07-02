<?php

use App\Http\Controllers\AccesibilidadController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CredencialController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthCheckCuston;
use App\Http\Middleware\AuthNotCheck;
use App\Models\Asistencia;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'index'])->name('auth.index')->middleware([AuthNotCheck::class]);
Route::post('/login', [AuthController::class, 'store'])->name('auth.store')->middleware([AuthNotCheck::class]);

Route::middleware([AuthCheckCuston::class])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::resource('roles', RoleController::class);
    Route::patch('/roles/permisos/{id}', [RoleController::class, 'updatePermissions'])->name('roles.update.permissions');
    Route::resource('usuarios', UserController::class);
    Route::resource('salas', SalaController::class);
    Route::resource('horarios', HorarioController::class);
    Route::resource('gestiones', GestionController::class);
    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('credenciales', CredencialController::class);
    Route::get('/ingresos', [IngresoController::class, 'index'])->name('ingresos.index');
    Route::get('/verificar-credencial/{codigo}', [IngresoController::class, 'verificar'])->name('ingresos.verificar');
    Route::get('/asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');
    Route::get('/asistencias/{codigo}', [AsistenciaController::class, 'verificar'])->name('asistencias.verificar');

    //theme
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/theme/{theme}', [ThemeController::class, 'setTheme'])->name('setTheme');
    Route::get('/mode/{mode}', [ThemeController::class, 'setMode'])->name('setMode');
    Route::get('/accessibility/{option}', [ThemeController::class, 'setAccessibility'])->name('setAccessibility');

    //Accesibilidad
    Route::get('accesibilidad',[AccesibilidadController::class,'accesibilidad'])->name('accesibilidad');
    //Reportes
    Route::get('/reporte-asistencia',[AsistenciaController::class,'reporteAsistencia'])->name('reportes.asistencias');
    Route::get('/reporte-estudiantes',[EstudianteController::class,'reporteEstudiantes'])->name('reportes.estudiantes');
    Route::get('/reporte-ingresos',[IngresoController::class,'reporteIngresos'])->name('reportes.ingresos');
});
