@extends('layouts.admin')

@section('title', 'Detalhes do Pedido')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Pedido #{{ $pedido->id }}</h1>
        <div class="flex space-x-2">
            <span class="px-5 py-1 border text-sm font-semibold rounded-full flex justify-between items-center
                {{ $pedido->status == 'Cancelado' ? 'bg-red-100 text-red-800 border-red-800' : 
                   ($pedido->status == 'Entregue' ? 'bg-green-100 text-green-800 border-green-800' : 
                   'bg-yellow-100 text-yellow-800 border-yellow-800') }}">
                {{ $pedido->status }}
            </span>
            <a href="{{ route('admin.pedidos.index') }}" 
            class="px-5 py-2 rounded-full border-gray-400 border hover:bg-gray-700 hover:text-white hover:border-gray-700">
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        <div class="bg-white rounded-lg border p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold mb-4">Itens do Pedido</h2>
            <div class="divide-y divide-gray-200">
                @foreach($pedido->itens as $item)
                <div class="py-4 flex">
                    <div class="h-16 w-16 bg-gray-200 rounded-md overflow-hidden mr-4">
                        <img src="{{ asset($item->produto->imagem ?? 'assets/images/produto-sem-imagem.jpg') }}" 
                             alt="{{ $item->produto->nome }}" class="h-full w-full object-cover">
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium">{{ $item->produto->nome }}</h3>
                        <p class="text-sm text-gray-600">Quantidade: {{ $item->quantidade }}</p>
                        <p class="text-sm text-gray-600">Preço unitário: R$ {{ number_format(($item->subtotal / $item->quantidade), 2, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="border-t border-gray-200 pt-4 mt-4">
                <div class="flex justify-between py-2">
                    <span>Subtotal</span>
                    <span>R$ {{ number_format($pedido->preco_total - $pedido->taxa_entrega, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span>Taxa de entrega</span>
                    <span>R$ {{ number_format($pedido->taxa_entrega, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 font-bold text-lg">
                    <span>Total</span>
                    <span>R$ {{ number_format($pedido->preco_total, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-lg border p-6">
                <h2 class="text-lg font-semibold mb-4">Cliente</h2>
                <div class="space-y-2">
                    <p><strong>Nome:</strong> {{ $pedido->cliente->nome }}</p>
                    <p><strong>Email:</strong> {{ $pedido->cliente->email }}</p>
                    <p><strong>Telefone:</strong> {{ $pedido->cliente->telefone }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg border p-6">
                <h2 class="text-lg font-semibold mb-4">Endereço de Entrega</h2>
                <div class="space-y-2">
                    <p>{{ $pedido->endereco->logradouro }}, {{ $pedido->endereco->numero }}</p>
                    <p>{{ $pedido->endereco->bairro }}</p>
                    <p>{{ $pedido->endereco->cidade }}/{{ $pedido->endereco->estado }}</p>
                    <p>CEP: {{ $pedido->endereco->cep }}</p>
                    @if($pedido->endereco->complemento)
                    <p>Complemento: {{ $pedido->endereco->complemento }}</p>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-lg border p-6">
                <h2 class="text-lg font-semibold mb-4">Atualizar Status</h2>
                <form action="{{ route('admin.pedidos.status', $pedido->id) }}" method="POST">
                    @csrf
                    <select name="status" class="w-full border border-gray-300 rounded p-2 mb-3">
                        <option value="Recebido" {{ $pedido->status == 'Recebido' ? 'selected' : '' }}>Recebido</option>
                        <option value="Em preparo" {{ $pedido->status == 'Em preparo' ? 'selected' : '' }}>Em preparo</option>
                        <option value="A caminho" {{ $pedido->status == 'A caminho' ? 'selected' : '' }}>A caminho</option>
                        <option value="Entregue" {{ $pedido->status == 'Entregue' ? 'selected' : '' }}>Entregue</option>
                        <option value="Cancelado" {{ $pedido->status == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                        Atualizar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection