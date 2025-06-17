<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClienteAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.cliente-login');
    }

    public function login(Request $request)
    {
        \Log::info('Tentativa de login iniciada', ['email' => $request->email]);
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        \Log::info('Credenciais válidas', ['email' => $request->email]);

        $cliente = Cliente::where('email', $request->email)->first();

        if ($cliente && Hash::check($request->password, $cliente->senha)) {
            Auth::guard('cliente')->login($cliente, $request->remember);
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        \Log::warning('Falha no login', ['email' => $request->email]);
        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes,email',
            'password' => 'required|string|min:8|confirmed',
            'cpf' => 'required|string|unique:clientes,cpf',
            'telefone' => 'required|string',
        ]);

        $cliente = Cliente::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => Hash::make($request->password),
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
        ]);

        Auth::guard('cliente')->login($cliente);

        return redirect()->route('home');
    }
    
    public function logout()
    {
        Auth::guard('cliente')->logout();
        return redirect('/');
    }
    
    public function showRegistrationForm()
    {
        return view('auth.cliente-register');
    }
    
}