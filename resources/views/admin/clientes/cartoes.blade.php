@extends('layouts.admin')

@section('title', 'Cartões do Cliente')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Cartões de {{ $cliente->nome }}</h1>
        <a href="{{ route('admin.clientes.index') }}" 
           class="px-5 py-2 rounded-full border-gray-400 border hover:bg-gray-700 hover:text-white hover:border-gray-700">
            Voltar
        </a>
    </div>

    <div class="bg-white rounded-lg border overflow-hidden p-5">
        @if($cartoes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($cartoes as $cartao)
                <div class="relative text-white rounded-xl p-6 shadow-lg overflow-hidden
                    {{ $cartao->bandeira == 'VISA' ? 'bg-gradient-to-br from-blue-500 to-blue-700' : 'bg-gradient-to-br from-orange-400 to-orange-600' }}">
                    
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $cartao->apelido }}</h3>
                            <span class="text-xs bg-white text-blue-700 px-2 py-1 rounded-full">
                                {{ $cartao->tipo }}
                            </span>
                        </div>
                        <div>
                            @if($cartao->bandeira == 'VISA')
                            <img src="{{ asset('images/visa.png') }}" alt="Visa" class="h-8">
                            @else
                            <img src="{{ asset('images/mastercard.png') }}" alt="Mastercard" class="h-8">
                            @endif
                        </div>
                    </div>

                    <div class="mb-6 tracking-widest text-xl">
                        **** **** **** {{ substr($cartao->numero, -4) }}
                    </div>

                    <div class="flex justify-between text-sm">
                        <div>
                            <p class="uppercase text-gray-200">Titular</p>
                            <p class="font-semibold">{{ $cartao->nome_titular }}</p>
                        </div>
                        <div>
                            <p class="uppercase text-gray-200">Validade</p>
                            <p class="font-semibold">{{ $cartao->data_validade->format('m/Y') }}</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.clientes.cartoes.remover', [$cliente->id, $cartao->id]) }}" method="POST" class="absolute top-2 right-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este cartão?')"
                            class="p-1.5 bg-white/20 hover:bg-white/30 rounded-full transition">
                            <i class='bx bx-trash text-white text-lg'></i>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        @else
        <div class="p-6 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum cartão cadastrado</h3>
            <p class="mt-1 text-sm text-gray-500">Este cliente ainda não possui cartões cadastrados.</p>
        </div>
        @endif
    </div>
</div>
@endsection