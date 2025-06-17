@extends('layouts.admin')

@section('title', 'Endereços do Cliente')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Endereços de {{ $cliente->nome }}</h1>
        <a href="{{ route('admin.clientes.index') }}" 
           class="px-5 py-2 rounded-full border-gray-400 border hover:bg-gray-700 hover:text-white hover:border-gray-700">
            Voltar
        </a>
    </div>

    <div class="bg-white rounded-lg border overflow-hidden">
        @if($enderecos->count() > 0)
        <div class="divide-y divide-gray-200">
            @foreach($enderecos as $endereco)
            <div class="p-6 hover:bg-gray-50">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <h3 class="font-semibold capitalize">{{ strtolower($endereco->tipo) }}</h3>
                            @if($endereco->tipo == 'Residencial')
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            @else
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            @endif
                        </div>
                        <p class="text-gray-700">{{ $endereco->logradouro }}, {{ $endereco->numero }}</p>
                        @if($endereco->complemento)
                        <p class="text-sm text-gray-600">Complemento: {{ $endereco->complemento }}</p>
                        @endif
                        <p class="text-gray-700">{{ $endereco->bairro }}</p>
                        <p class="text-gray-700">{{ $endereco->cidade }}/{{ $endereco->estado }}</p>
                        <p class="text-gray-700">CEP: {{ $endereco->cep }}</p>
                    </div>
                    <div class="flex gap-2">
                        <form action="{{ route('admin.clientes.enderecos.remover', [$cliente->id, $endereco->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este endereço?')"
                                class="p-2 text-red-500 hover:bg-red-50 rounded-full transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="p-6 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum endereço cadastrado</h3>
            <p class="mt-1 text-sm text-gray-500">Este cliente ainda não possui endereços cadastrados.</p>
        </div>
        @endif
    </div>
</div>
@endsection