@extends('layouts.app')

@section('title', 'Confirmar Pedido')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-color-secondary mb-8">Confirmar Pedido</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-lg border p-6">
            <h2 class="text-xl font-bold text-color-secondary mb-4">Itens do Pedido</h2>

            <div class="divide-y divide-gray-200">
                @foreach($sacola->itens as $item)
                <div class="py-4 flex">
                    <div class="w-24 h-24 flex-shrink-0">
                        <img src="{{ asset($item->produto->imagem) }}" alt="{{ $item->produto->nome }}"
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="ml-4 flex-grow">
                        <h3 class="text-lg font-semibold">{{ $item->produto->nome }}</h3>
                        <p class="text-color-primary font-bold">R$
                            {{ number_format($item->produto->preco, 2, ',', '.') }}</p>
                        <p class="text-gray-600">Quantidade: {{ $item->quantidade }}</p>
                        <p class="text-gray-600">Subtotal: R$ {{ number_format($item->subtotal, 2, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6 border-t pt-4">
                <div class="flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span class="text-color-primary">R$
                        {{ number_format($sacola->calcularTotal(), 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border p-6 h-fit sticky top-4">
            <h2 class="text-xl font-bold text-color-secondary mb-4">Informações de Entrega e Pagamento</h2>

            <form action="{{ route('pedidos.finalizar') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Endereço de Entrega</label>
                    @foreach($enderecos as $endereco)
                    <div class="flex items-center mb-2">
                        <input type="radio" name="endereco_id" id="endereco_{{ $endereco->id }}"
                            value="{{ $endereco->id }}" class="mr-2" {{ $loop->first ? 'checked' : '' }}>
                        <label for="endereco_{{ $endereco->id }}">
                            {{ $endereco->logradouro }}, {{ $endereco->numero }} - {{ $endereco->bairro }},
                            {{ $endereco->cidade }}/{{ $endereco->estado }}
                        </label>
                    </div>
                    @endforeach
                    <a href="{{ route('perfil.enderecos') }}"
                        class="text-color-primary text-sm hover:underline">Gerenciar endereços</a>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Método de Pagamento</label>
                    <select name="metodo_pagamento_id" id="metodo_pagamento" class="w-full border rounded-lg p-2 mb-2">
                        @foreach($metodosPagamento as $metodo)
                        <option value="{{ $metodo->id }}">{{ $metodo->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6" id="cartao_container">
                    <label class="block text-gray-700 font-medium mb-2">Cartão de Crédito</label>
                    @if($cartoes->count() > 0)
                    @foreach($cartoes as $cartao)
                    <div class="flex items-center mb-2">
                        <input type="radio" name="cartao_id" id="cartao_{{ $cartao->id }}" value="{{ $cartao->id }}"
                            class="mr-2" {{ $loop->first ? 'checked' : '' }}>
                        <label for="cartao_{{ $cartao->id }}">
                            {{ $cartao->bandeira }} - **** **** **** {{ substr($cartao->numero, -4) }}
                        </label>
                    </div>
                    @endforeach
                    @else
                    <p class="text-red-500">Você não tem cartões cadastrados.</p>
                    @endif
                    <a href="{{ route('perfil.cartoes') }}" class="text-color-primary text-sm hover:underline">Gerenciar
                        cartões</a>
                </div>

                <div class="mb-6 hidden" id="troco_container">
                    <label class="block text-gray-700 font-medium mb-2">Troco para</label>
                    <input type="number" name="troco" class="w-full border rounded-lg p-2"
                        placeholder="Informe o valor para troco" min="{{ $sacola->calcularTotal() }}" step="0.01">
                </div>

                <button type="submit" class="w-full bg-color-primary text-white py-3 rounded-lg hover:bg-opacity-90">
                    Confirmar Pedido
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('metodo_pagamento').addEventListener('change', function() {
    const metodo = this.value;
    const cartaoContainer = document.getElementById('cartao_container');
    const trocoContainer = document.getElementById('troco_container');

    if (metodo == 1) {
        cartaoContainer.classList.remove('hidden');
        trocoContainer.classList.add('hidden');
    } else if (metodo == 2) {
        cartaoContainer.classList.add('hidden');
        trocoContainer.classList.remove('hidden');
    } else {
        cartaoContainer.classList.add('hidden');
        trocoContainer.classList.add('hidden');
    }
});
</script>
@endpush
@endsection