@extends('layouts.app')

@section('title', 'Nossos Produtos')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <h1 class="text-3xl font-bold text-color-secondary">Nossos Produtos</h1>

        <div class="flex flex-wrap gap-2">
            @foreach($categorias as $categoria)
            <a href="#"
                class="px-4 py-2 rounded-full border border-color-primary text-color-primary hover:bg-color-primary hover:text-white transition">
                {{ $categoria->nome }}
            </a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($produtos as $produto)
        <div class="product-card bg-white rounded-xl border overflow-hidden hover:shadow-lg transition-shadow">
            @if($produto->mais_vendido)
            <div class="absolute top-2 left-2 bg-color-tertiary text-white text-xs font-bold px-2 py-1 rounded-full">
                Mais vendido
            </div>
            @endif

            <div class="w-100 overflow-hidden flex items-center justify-center p-4">
                <img src="{{ asset($produto->imagem) }}" alt="{{ $produto->nome }}"
                    class="max-h-full max-w-full object-contain">
            </div>

            <div class="p-4">
                <h3 class="font-semibold text-lg text-color-secondary">{{ $produto->nome }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $produto->categoria->nome }}</p>

                <div class="mt-3 flex justify-between items-center">
                    <span class="text-color-primary font-bold">R$
                        {{ number_format($produto->preco, 2, ',', '.') }}</span>

                    <form action="{{ route('sacola.adicionar') }}" method="POST" class="flex items-center">
                        @csrf
                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">

                        <div class="flex items-center border rounded-full overflow-hidden">
                            <button type="button" onclick="decrementQuantity(this)"
                                class="px-2 py-1 bg-gray-100 text-color-secondary hover:bg-gray-200">
                                <i class='bx bx-minus text-sm'></i>
                            </button>
                            <input type="number" name="quantidade" value="1" min="1" max="99"
                                class="w-10 text-center border-none quantity-input">
                            <button type="button" onclick="incrementQuantity(this)"
                                class="px-2 py-1 bg-gray-100 text-color-secondary hover:bg-gray-200">
                                <i class='bx bx-plus text-sm'></i>
                            </button>
                        </div>

                        <button type="submit"
                            class="ml-2 bg-color-primary text-white p-2 rounded-full hover:bg-opacity-90">
                            <i class='bx bx-shopping-bag'></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $produtos->links() }}
    </div>
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