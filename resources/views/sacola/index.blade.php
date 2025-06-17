@extends('layouts.app')

@section('title', 'Minha Sacola')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-color-secondary mb-8">Minha Sacola</h1>

    @if($sacola && $sacola->itens->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-lg border p-6">
            <div class="divide-y divide-gray-200">
                @foreach($sacola->itens as $item)
                <div class="py-4 flex flex-col md:flex-row gap-4">
                    <div class="w-full md:w-24 h-24 flex-shrink-0">
                        <img src="{{ asset($item->produto->imagem) }}" alt="{{ $item->produto->nome }}"
                            class="w-full h-full object-cover rounded-lg">
                    </div>

                    <div class="flex-grow">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-color-secondary">{{ $item->produto->nome }}
                                </h3>
                                <p class="text-color-primary font-bold mt-1">R$
                                    {{ number_format($item->produto->preco, 2, ',', '.') }}</p>
                            </div>
                            <form action="{{ route('sacola.remover', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class='bx bx-trash text-xl'></i>
                                </button>
                            </form>
                        </div>

                        <div class="mt-4 flex items-center">
                            <form action="{{ route('sacola.atualizar', $item->id) }}" method="POST"
                                class="flex items-center">
                                @csrf
                                @method('PATCH')
                                <button type="button" onclick="decrementQuantity(this)"
                                    class="bg-gray-200 px-3 py-1 rounded-l-lg text-color-secondary hover:bg-gray-300">
                                    <i class='bx bx-minus'></i>
                                </button>
                                <input type="number" name="quantidade" value="{{ $item->quantidade }}" min="1" max="99"
                                    class="w-16 text-center border-t border-b border-gray-200 py-1 quantity-input">
                                <button type="button" onclick="incrementQuantity(this)"
                                    class="bg-gray-200 px-3 py-1 rounded-r-lg text-color-secondary hover:bg-gray-300">
                                    <i class='bx bx-plus'></i>
                                </button>
                                <button type="submit"
                                    class="ml-4 text-sm text-color-primary hover:underline">Atualizar</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-lg border p-6 h-fit sticky top-4">
            <h2 class="text-xl font-bold text-color-secondary mb-4">Resumo do Pedido</h2>

            <div class="space-y-3">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>R$ {{ number_format($sacola->calcularTotal(), 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Taxa de Entrega</span>
                    <span>Grátis</span>
                </div>
                <div class="border-t border-gray-200 pt-3 mt-3">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span class="text-color-primary">R$
                            {{ number_format($sacola->calcularTotal(), 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('pedidos.confirmar') }}"
                class="mt-6 block w-full bg-color-primary text-white text-center py-3 rounded-lg hover:bg-opacity-90 transition">
                Finalizar Pedido
            </a>
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg border p-8 text-center">
        <i class='bx bx-cart text-6xl text-gray-300 mb-4'></i>
        <h2 class="text-xl font-semibold text-gray-600 mb-2">Sua sacola está vazia</h2>
        <p class="text-gray-500 mb-6">Adicione produtos para continuar</p>
        <a href="{{ route('home') }}"
            class="inline-block bg-color-primary text-white px-6 py-2 rounded-lg hover:bg-opacity-90">
            Voltar às compras
        </a>
    </div>
    @endif
</div>


@push('scripts')
<script>
function incrementQuantity(button) {
    const input = button.parentElement.querySelector('.quantity-input');
    input.value = parseInt(input.value) + 1;
}

function decrementQuantity(button) {
    const input = button.parentElement.querySelector('.quantity-input');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('change', function() {
        if (this.value < 1) this.value = 1;
        if (this.value > 99) this.value = 99;
        this.form.submit();
    });
});
</script>
@endpush
@endsection