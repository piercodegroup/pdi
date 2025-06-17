@extends('layouts.admin')

@section('title', 'Categorias')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Categorias</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.categorias.create') }}"
                class="px-4 py-2 bg-green-50 text-green-700 rounded border-green-500 border hover:bg-green-600 hover:text-white hover:border-green-600">
                Cadastrar Categoria
            </a>
            <a href="{{ route('admin.categorias.relatorio') }}"
                class="px-4 py-2 bg-blue-50 text-blue-700 rounded border-blue-500 border hover:bg-blue-600 hover:text-white hover:border-blue-600">
                Relatório
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagem</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produtos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($categorias as $categoria)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset($categoria->imagem) }}" alt="{{ $categoria->nome }}" class="h-12 w-12 rounded object-cover">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $categoria->nome }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ Str::limit($categoria->descricao, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $categoria->produtos->count() ?? 0 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.categorias.edit', $categoria->id) }}" class="border border-yellow-600 p-2 px-4 rounded-full text-yellow-600 hover:bg-yellow-600 hover:text-white hover:border-yellow-600">Editar</a>

                                <form action="{{ route('admin.categorias.destroy', $categoria->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Tem certeza que deseja excluir esta categoria?')" class="border border-red-600 p-2 px-4 rounded-full text-red-600 hover:bg-red-600 hover:text-white hover:border-red-600">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
            {{ $categorias->links() }}
        </div>
    </div>
</div>
@endsection