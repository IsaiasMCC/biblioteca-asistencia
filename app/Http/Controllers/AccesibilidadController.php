<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccesibilidadController extends Controller
{
    public function accesibilidad()
    {
        return view('accesibilidad');
    }
}
