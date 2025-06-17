@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-color-secondary mb-8">Meu Perfil</h1>

    <div class="bg-white rounded-lg border p-6">
        <form action="{{ route('perfil.atualizar') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Nome</label>
                    <input type="text" name="nome" value="{{ old('nome', $cliente->nome) }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">E-mail</label>
                    <input type="email" name="email" value="{{ old('email', $cliente->email) }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Telefone</label>
                    <input type="text" name="telefone" value="{{ old('telefone', $cliente->telefone) }}"
                        class="w-full border rounded-lg px-4 py-2">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">CPF</label>
                    <input type="text" value="{{ $cliente->cpf }}"
                        class="w-full border rounded-lg px-4 py-2 bg-gray-100" readonly>
                </div>
            </div>

            <h2 class="text-xl font-bold text-color-secondary mt-8 mb-4">Alterar Senha</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Senha Atual</label>
                    <input type="password" name="senha_atual" class="w-full border rounded-lg px-4 py-2">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Nova Senha</label>
                    <input type="password" name="nova_senha" class="w-full border rounded-lg px-4 py-2">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Confirmar Nova Senha</label>
                    <input type="password" name="nova_senha_confirmation" class="w-full border rounded-lg px-4 py-2">
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="bg-color-primary text-white px-6 py-2 rounded-lg hover:bg-opacity-90">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
@endsection