<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\Ingreso;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $lastMonth = Carbon::now()->subMonth();

        $countUsers = User::all()->count();
        $countUsers = User::all()->count();
        $ingresos = Ingreso::all()->count();
        $asistencias = Asistencia::all()->count();
        $fichasList = Ingreso::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->get();
        return view('home', compact('countUsers', 'ingresos', 'asistencias', 'fichasList'));
    }
}
