@extends('layouts.admin')

@section('title', 'Usuários Administrativos')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Usuários Administrativos</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.usuarios.create') }}"
                class="px-4 py-2 bg-green-50 text-green-700 rounded border-green-500 border hover:bg-green-600 hover:text-white hover:border-green-600">
                Cadastrar Usuário
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cadastrado em</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $usuario->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $usuario->nome }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $usuario->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.usuarios.show', $usuario->id) }}" 
                                class="border border-gray-200 p-2 px-4 rounded-full text-gray-400 mr-1 hover:bg-gray-700 hover:text-white hover:border-gray-700">Ver</a>

                            <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
                                class="border border-yellow-600 p-2 px-4 rounded-full text-yellow-600 mr-1 hover:bg-yellow-600 hover:text-white hover:border-yellow-600">Editar</a>

                            <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este usuário?')"
                                    class="border border-red-600 p-2 px-4 rounded-full text-red-600 hover:bg-red-600 hover:text-white hover:border-red-600">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
            {{ $usuarios->links() }}
        </div>
    </div>
</div>
@endsection