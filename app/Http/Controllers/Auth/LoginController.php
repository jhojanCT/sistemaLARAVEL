<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    

    // Muestra el formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesa el inicio de sesión
    public function login(Request $request) 
    {
    // Validar los datos
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $credentials = $request->only('email', 'password');

    // Intentar autenticar al usuario
    if (Auth::attempt($credentials)) {
        // Regenerar sesión para seguridad
        $request->session()->regenerate();

        // Redirigir a la ruta deseada
        return redirect()->intended('filtros'); // Cambia 'filtros' por la ruta del dashboard o home
    }

    // Si falla, redirige de vuelta con un mensaje de error
    return back()->withErrors([
        'email' => 'Las credenciales no coinciden con nuestros registros.',
    ])->onlyInput('email');
    }


    // Cierra sesión
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
