@extends('layouts.admin')

@section('title', 'Relatório de Clientes')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Relatório de Clientes</h1>
        <a href="{{ route('admin.clientes.index') }}" 
           class="px-5 py-2 rounded-full border-gray-400 border hover:bg-gray-700 hover:text-white hover:border-gray-700">
            Voltar
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-semibold mb-2">Total de Clientes</h3>
            <p class="text-3xl font-bold">{{ $totalClientes }}</p>
        </div>
        
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-semibold mb-2">Novos Clientes (Mês)</h3>
            <p class="text-3xl font-bold">{{ $novosClientesMes }}</p>
        </div>
        
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-semibold mb-2">Clientes Ativos</h3>
            <p class="text-3xl font-bold">{{ $clientesAtivos }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-semibold mb-4">Cadastros nos Últimos 6 Meses</h3>
            <canvas id="clientesChart" height="300"></canvas>
        </div>
        
        <div class="bg-white rounded-lg border p-6">
            <h3 class="text-lg font-semibold mb-4">Top 5 Clientes</h3>
            <div class="space-y-4">
                @foreach($topClientes as $cliente)
                <div class="border-b pb-4 last:border-b-0 last:pb-0">
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="font-medium">{{ $cliente->nome }}</h4>
                            <p class="text-sm text-gray-600">{{ $cliente->email }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold">R$ {{ number_format($cliente->pedidos_sum_preco_total, 2, ',', '.') }}</p>
                            <p class="text-sm text-gray-600">{{ $cliente->pedidos_count }} pedidos</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('clientesChart').getContext('2d');
        const labels = {!! json_encode($clientesPorMes->pluck('label')) !!};
        const data = {!! json_encode($clientesPorMes->pluck('total')) !!};
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Clientes Cadastrados',
                    data: data,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgba(59, 130, 246, 1)',
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