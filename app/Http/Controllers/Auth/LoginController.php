<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Muestra el formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesa el inicio de sesión
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        // Busca al usuario en la base de datos
        $user = User::where('name', $credentials['name'])->first();

        // Verifica las credenciales
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::guard('users')->login($user);
            return redirect()->intended('filtros');
        }

        return back()->withErrors([
            'name' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    // Cierra sesión
    public function logout(Request $request)
    {
        Auth::guard('users')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
