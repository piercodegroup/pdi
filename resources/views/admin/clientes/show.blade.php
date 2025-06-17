@extends('layouts.admin')

@section('title', 'Detalhes do Cliente')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ $cliente->nome }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.clientes.index') }}" 
            class="px-5 py-2 rounded-full border-gray-400 border hover:bg-gray-700 hover:text-white hover:border-gray-700">
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg border p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold mb-4">Informações do Cliente</h2>
            
            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Nome</h3>
                    <p>{{ $cliente->nome }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Email</h3>
                    <p>{{ $cliente->email }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Telefone</h3>
                    <p>{{ $cliente->telefone ?? 'Não informado' }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500">CPF</h3>
                    <p>{{ $cliente->cpf ?? 'Não informado' }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Total de Pedidos</h3>
                    <p>{{ $cliente->pedidos_count }}</p>
                </div>
                
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Cadastrado em</h3>
                    <p>{{ $cliente->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-lg border p-6">
                <h2 class="text-lg font-semibold mb-4">Endereços</h2>
                
                @if($cliente->enderecos->count() > 0)
                    <div class="space-y-4">
                        @foreach($cliente->enderecos as $endereco)
                        <div class="border-b pb-4 last:border-b-0 last:pb-0">
                            <h3 class="font-medium">{{ $endereco->tipo }}</h3>
                            <p>{{ $endereco->logradouro }}, {{ $endereco->numero }}</p>
                            <p>{{ $endereco->bairro }}</p>
                            <p>{{ $endereco->cidade }}/{{ $endereco->estado }}</p>
                            <p>CEP: {{ $endereco->cep }}</p>
                            @if($endereco->complemento)
                            <p>Complemento: {{ $endereco->complemento }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Nenhum endereço cadastrado.</p>
                @endif
            </div>

            <div class="bg-white rounded-lg border p-6">
                <h2 class="text-lg font-semibold mb-4">Cartões</h2>
                
                @if($cliente->cartoes->count() > 0)
                    <div class="space-y-4">
                        @foreach($cliente->cartoes as $cartao)
                        <div class="border-b pb-4 last:border-b-0 last:pb-0">
                            <h3 class="font-medium">{{ $cartao->apelido }} ({{ $cartao->bandeira }} - {{ $cartao->tipo }})</h3>
                            <p>Terminado em {{ substr($cartao->numero, -4) }}</p>
                            <p>Validade: {{ $cartao->data_validade->format('m/Y') }}</p>
                            <p>Titular: {{ $cartao->nome_titular }}</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Nenhum cartão cadastrado.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection