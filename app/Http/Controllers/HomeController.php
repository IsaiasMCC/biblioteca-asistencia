<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $lastMonth = Carbon::now()->subMonth();
        // dd($lastMonth->year);
        // $countIngresos = Pago::where('estado', 'Pago realizado')
            // ->whereMonth('fecha_pago', $lastMonth->month)
            // ->whereYear('fecha_pago', $lastMonth->year)
            // ->sum('costo');
        // dd($countIngresos);
        // $ingresos = Pago::where('estado', 'Pago realizado')
            // ->whereMonth('fecha_pago', $lastMonth->month)
            // ->whereYear('fecha_pago', $lastMonth->year)
            // ->get();
        // dd($ingresos);

        $countUsers = User::all()->count();
        
        // $fichas = Pago::select(
        //     DB::raw('DATE(created_at) as date'),
        //     DB::raw('SUM(costo) as total_cost')
        // )
        //     ->where('estado', '!=', 'Pago realizado')
        //     ->groupBy(DB::raw('DATE(created_at)'))
        //     ->get();
        // dd($fichas);
        $countUsers = User::all()->count();


        return view('home', compact('countUsers'));
    }
}
