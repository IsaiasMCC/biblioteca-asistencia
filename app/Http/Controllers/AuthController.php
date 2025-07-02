<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(AuthRequest $request)
    {
        $credentials = $request->validated();
        try {
            $userAuth = User::where('estado', true)
                ->where('email', $credentials['email'])
                ->first();

            if (!$userAuth) {
                return redirect()->back()->with('error', 'El usuario no está activo o no existe.')->withInput();
            }
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect('/home');
            }
            return redirect()->back()->with('error', 'Credenciales incorrectas.')->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Credenciales incorrectas.')->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.index');
    }
}
