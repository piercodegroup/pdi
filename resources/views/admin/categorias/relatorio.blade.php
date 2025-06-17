@extends('layouts.admin')

@section('title', 'Relatório de Categorias')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Relatório de Categorias</h1>
        <a href="{{ route('admin.categorias.index') }}" 
           class="px-5 py-2 rounded-full border-gray-400 border hover:bg-gray-700 hover:text-white hover:border-gray-700">
            Voltar
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-medium text-gray-500 mb-2">Total de Categorias</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ $totalCategorias }}</p>
        </div>
        
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-medium text-gray-500 mb-2">Com Produtos</h3>
            <p class="text-3xl font-bold text-green-600">{{ $categoriasComProdutos }}</p>
        </div>
        
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-medium text-gray-500 mb-2">Sem Produtos</h3>
            <p class="text-3xl font-bold text-gray-600">{{ $categoriasSemProdutos }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Categorias com Mais Produtos</h3>
            <div class="space-y-4">
                @foreach($categoriasMaisProdutos as $categoria)
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">{{ $categoria->nome }}</span>
                        <span class="text-sm font-medium text-gray-700">{{ $categoria->produtos_count }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-indigo-600 h-2.5 rounded-full" 
                             style="width: {{ ($categoria->produtos_count / ($categoriasMaisProdutos->first()->produtos_count ?: 1)) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Cadastro de Categorias (Últimos 6 meses)</h3>
            <canvas id="categoriasChart" height="200"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('categoriasChart').getContext('2d');
    const labels = @json($categoriasPorMes->pluck('label'));
    const data = @json($categoriasPorMes->pluck('total'));
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Categorias Cadastradas',
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