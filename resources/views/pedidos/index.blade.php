@extends('layouts.app')

@section('title', 'Meus Pedidos')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-color-secondary mb-8">Meus Pedidos</h1>

    @if($pedidos->count() > 0)
    <div class="bg-white rounded-lg border overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nº Pedido
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($pedidos as $pedido)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">#{{ str_pad($pedido->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">R$ {{ number_format($pedido->preco_total, 2, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $pedido->status == 'Entregue' ? 'bg-green-100 text-green-800' : 
                               ($pedido->status == 'Cancelado' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ $pedido->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('pedidos.show', $pedido->id) }}"
                            class="text-color-primary hover:underline">Detalhes</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pedidos->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg border p-8 text-center">
        <i class='bx bx-package text-6xl text-gray-300 mb-4'></i>
        <h2 class="text-xl font-semibold text-gray-600 mb-2">Você ainda não fez nenhum pedido</h2>
        <p class="text-gray-500 mb-6">Comece a comprar agora mesmo</p>
        <a href="{{ route('produtos.index') }}"
            class="inline-block bg-color-primary text-white px-6 py-2 rounded-lg hover:bg-opacity-90">
            Ver Produtos
        </a>
    </div>
    @endif
</div>
@endsection