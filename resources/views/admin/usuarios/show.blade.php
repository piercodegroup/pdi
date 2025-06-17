@extends('layouts.admin')

@section('title', 'Detalhes do Usuário')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detalhes do Usuário: {{ $usuario->name }}</h1>
        <a href="{{ route('admin.usuarios.index') }}" 
           class="px-5 py-2 rounded-full border-gray-400 border hover:bg-gray-700 hover:text-white hover:border-gray-700">
            Voltar
        </a>
    </div>

    <div class="bg-white rounded-lg border p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informações Básicas</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nome</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $usuario->nome }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $usuario->email }}</p>
                    </div>
                </div>
            </div>
            
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Status e Cadastro</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Cadastrado em</label>
                        <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Última atualização</label>
                        <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($usuario->updated_at)->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection