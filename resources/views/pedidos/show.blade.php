@extends('layouts.app')

@section('title', 'Detalhes do Pedido')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-color-secondary">Pedido #{{ str_pad($pedido->id, 6, '0', STR_PAD_LEFT) }}
        </h1>
        <span class="px-3 py-1 rounded-full text-sm font-semibold 
            {{ $pedido->status == 'Entregue' ? 'bg-green-100 text-green-800' : 
               ($pedido->status == 'Cancelado' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
            {{ $pedido->status }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Itens do Pedido -->
        <div class="lg:col-span-2 bg-white rounded-lg border p-6">
            <h2 class="text-xl font-bold text-color-secondary mb-4">Itens do Pedido</h2>

            <div class="divide-y divide-gray-200">
                @foreach($pedido->itens as $item)
                <div class="py-4 flex">
                    <div class="w-24 h-24 flex-shrink-0">
                        <img src="{{ asset($item->produto->imagem) }}" alt="{{ $item->produto->nome }}"
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="ml-4 flex-grow">
                        <h3 class="text-lg font-semibold">{{ $item->produto->nome }}</h3>
                        <p class="text-gray-600">Quantidade: {{ $item->quantidade }}</p>
                        <p class="text-color-primary font-bold">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6 border-t pt-4 space-y-2">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>R$ {{ number_format($pedido->preco_total, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Taxa de Entrega</span>
                    <span>Grátis</span>
                </div>
                <div class="flex justify-between font-bold text-lg pt-2 border-t">
                    <span>Total</span>
                    <span class="text-color-primary">R$ {{ number_format($pedido->preco_total, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Informações do Pedido -->
        <div class="bg-white rounded-lg border p-6 h-fit sticky top-4">
            <h2 class="text-xl font-bold text-color-secondary mb-4">Informações do Pedido</h2>

            <div class="space-y-4">
                <div>
                    <h3 class="font-medium text-gray-700">Data do Pedido</h3>
                    <p>{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <h3 class="font-medium text-gray-700">Endereço de Entrega</h3>
                    <p>{{ $pedido->endereco->logradouro }}, {{ $pedido->endereco->numero }}</p>
                    <p>{{ $pedido->endereco->bairro }}, {{ $pedido->endereco->cidade }}/{{ $pedido->endereco->estado }}
                    </p>
                    <p>CEP: {{ $pedido->endereco->cep }}</p>
                </div>

                <div>
                    <h3 class="font-medium text-gray-700">Método de Pagamento</h3>
                    <p>{{ $pedido->metodoPagamento->nome }}</p>
                    @if($pedido->cartao)
                    <p class="text-sm">Cartão terminado em {{ substr($pedido->cartao->numero, -4) }}</p>
                    @endif
                    @if($pedido->troco)
                    <p class="text-sm">Troco para R$ {{ number_format($pedido->troco, 2, ',', '.') }}</p>
                    @endif
                </div>

                <div>
                    <h3 class="font-medium text-gray-700">Previsão de Entrega</h3>
                    <p>{{ \Carbon\Carbon::parse($pedido->data_entrega)->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection