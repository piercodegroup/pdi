@extends('layouts.app')

@section('title', $produto->nome)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Imagem do Produto -->
        <div class="bg-white rounded-xl shadow-md p-6 flex justify-center">
            <img src="{{ asset($produto->imagem) }}" alt="{{ $produto->nome }}" class="max-h-96 object-contain">
        </div>

        <!-- Informações do Produto -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h1 class="text-3xl font-bold text-color-secondary">{{ $produto->nome }}</h1>
            <p class="text-color-primary text-xl font-bold mt-2">R$ {{ number_format($produto->preco, 2, ',', '.') }}
            </p>

            <div class="mt-4">
                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                    {{ $produto->categoria->nome }}
                </span>
                @if($produto->mais_vendido)
                <span
                    class="inline-block bg-color-tertiary rounded-full px-3 py-1 text-sm font-semibold text-white ml-2">
                    Mais vendido
                </span>
                @endif
            </div>

            <p class="mt-6 text-gray-600">{{ $produto->descricao }}</p>

            <!-- Formulário para adicionar ao carrinho -->
            <form action="{{ route('sacola.adicionar') }}" method="POST" class="mt-8">
                @csrf
                <input type="hidden" name="produto_id" value="{{ $produto->id }}">

                <div class="flex items-center gap-4">
                    <div class="flex items-center border rounded-full overflow-hidden">
                        <button type="button" onclick="decrementQuantity(this)"
                            class="px-3 py-1 bg-gray-100 text-color-secondary hover:bg-gray-200">
                            <i class='bx bx-minus'></i>
                        </button>
                        <input type="number" name="quantidade" value="1" min="1" max="99"
                            class="w-16 text-center border-none quantity-input">
                        <button type="button" onclick="incrementQuantity(this)"
                            class="px-3 py-1 bg-gray-100 text-color-secondary hover:bg-gray-200">
                            <i class='bx bx-plus'></i>
                        </button>
                    </div>

                    <button type="submit"
                        class="flex-1 bg-color-primary text-white py-3 px-6 rounded-full hover:bg-opacity-90 font-medium">
                        Adicionar à Sacola
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Produtos Relacionados -->
    @if($relacionados->count() > 0)
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-color-secondary mb-6">Você também pode gostar</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($relacionados as $produto)
            <div class="product-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <a href="{{ route('produtos.show', $produto->id) }}"
                    class="block h-48 overflow-hidden flex items-center justify-center p-4">
                    <img src="{{ asset($produto->imagem) }}" alt="{{ $produto->nome }}"
                        class="max-h-full max-w-full object-contain">
                </a>

                <div class="p-4">
                    <a href="{{ route('produtos.show', $produto->id) }}"
                        class="font-semibold text-lg text-color-secondary hover:underline">
                        {{ $produto->nome }}
                    </a>
                    <p class="text-color-primary font-bold mt-1">R$ {{ number_format($produto->preco, 2, ',', '.') }}
                    </p>

                    <form action="{{ route('sacola.adicionar') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                        <input type="hidden" name="quantidade" value="1">

                        <button type="submit"
                            class="w-full bg-color-primary text-white py-2 px-4 rounded-full hover:bg-opacity-90 text-sm">
                            Adicionar à Sacola
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
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
</script>
@endpush
@endsection