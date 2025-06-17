<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminUsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Administrador::latest()->paginate(10);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'senha' => ['required', 'confirmed', Rules\Password::defaults()],
            'tipo' => 'required|in:admin,gerente,operador',
            'status' => 'required|in:ativo,inativo',
        ]);

        Administrador::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => Hash::make($request->senha),
            'tipo' => $request->tipo,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    public function show($id)
    {
        $usuario = Administrador::findOrFail($id);
        return view('admin.usuarios.show', compact('usuario'));
    }

    public function edit($id)
    {
        $usuario = Administrador::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Administrador::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$usuario->id,
            'tipo' => 'required|in:admin,gerente,operador',
            'status' => 'required|in:ativo,inativo',
        ]);

        $data = [
            'nome' => $request->nome,
            'email' => $request->email,
            'tipo' => $request->tipo,
            'status' => $request->status,
        ];

        if ($request->senha) {
            $request->validate([
                'senha' => ['confirmed', Rules\Password::defaults()],
            ]);
            $data['senha'] = Hash::make($request->senha);
        }

        $usuario->update($data);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $usuario = Administrador::findOrFail($id);

        if ($usuario->tipo === 'admin' && Administrador::where('tipo', 'admin')->count() <= 1) {
            return back()->with('error', 'Não é possível excluir o último administrador.');
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuário removido com sucesso!');
    }

}