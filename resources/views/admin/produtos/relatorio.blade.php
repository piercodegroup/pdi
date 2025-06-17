@extends('layouts.admin')

@section('title', 'Relatório de Produtos')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Relatório de Produtos</h1>
        <a href="{{ route('admin.produtos.index') }}" 
           class="px-5 py-2 rounded-full border-gray-400 border hover:bg-gray-700 hover:text-white hover:border-gray-700">
            Voltar
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-medium text-gray-500 mb-2">Total de Produtos</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ $totalProdutos }}</p>
        </div>
        
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-medium text-gray-500 mb-2">Sem Estoque</h3>
            <p class="text-3xl font-bold text-red-600">{{ $produtosSemEstoque }}</p>
        </div>
        
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-medium text-gray-500 mb-2">Ativos</h3>
            <p class="text-3xl font-bold text-green-600">{{ $produtosAtivos }}</p>
        </div>
        
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-medium text-gray-500 mb-2">Inativos</h3>
            <p class="text-3xl font-bold text-gray-600">{{ $produtosInativos }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Produtos por Categoria</h3>
            <div class="space-y-4">
                @foreach($produtosPorCategoria as $categoria)
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">{{ $categoria->nome }}</span>
                        <span class="text-sm font-medium text-gray-700">{{ $categoria->produtos_count }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-indigo-600 h-2.5 rounded-full" 
                             style="width: {{ ($categoria->produtos_count / $totalProdutos) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Produtos Mais Vendidos</h3>
            <div class="space-y-4">
                @foreach($produtosMaisVendidos as $produto)
                <div class="flex items-center">
                    <img src="{{ asset($produto->imagem) }}" alt="{{ $produto->nome }}" class="h-10 w-10 rounded object-cover mr-3">
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-700">{{ $produto->nome }}</h4>
                        <p class="text-xs text-gray-500">{{ $produto->itens_pedido_count }} vendas</p>
                    </div>
                    <span class="text-sm font-medium text-indigo-600">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border p-6 mt-6">
        <h3 class="text-lg font-medium text-gray-700 mb-4">Cadastro de Produtos (Últimos 6 meses)</h3>
        <canvas id="produtosChart" height="100"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('produtosChart').getContext('2d');
    const labels = @json($produtosPorMes->pluck('label'));
    const data = @json($produtosPorMes->pluck('total'));
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Produtos Cadastrados',
                data: data,
                backgroundColor: 'rgba(79, 70, 229, 0.7)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection