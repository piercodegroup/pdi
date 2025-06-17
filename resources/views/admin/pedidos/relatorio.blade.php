@extends('layouts.admin')

@section('title', 'Relatório de Pedidos')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Relatório de Pedidos</h1>
        <a href="{{ route('admin.pedidos.index') }}" 
           class="px-5 py-2 rounded-full border-gray-400 border hover:bg-gray-700 hover:text-white hover:border-gray-700">
            Voltar
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <div class="bg-white rounded-lg border p-6">
            <h3 class="font-medium mb-2">Total de Vendas</h3>
            <p class="text-3xl font-bold">R$ {{ number_format($totalVendas, 2, ',', '.') }}</p>
            <p class="text-sm text-gray-500 mt-2">Últimos 30 dias</p>
        </div>

        <div class="bg-white rounded-lg border p-6">
            <h3 class="font-medium mb-2">Total de Pedidos</h3>
            <p class="text-3xl font-bold">{{ $pedidos30Dias->sum('total') }}</p>
            <p class="text-sm text-gray-500 mt-2">Últimos 30 dias</p>
        </div>

        <div class="bg-white rounded-lg border p-6">
            <h3 class="font-medium mb-2">Ticket Médio</h3>
            <p class="text-3xl font-bold">
                R$ {{ number_format($totalVendas / max($pedidos30Dias->sum('total'), 1), 2, ',', '.') }}
            </p>
            <p class="text-sm text-gray-500 mt-2">Por pedido</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        <div class="bg-white rounded-lg border p-6">
            <h3 class="font-medium mb-4">Pedidos nos últimos 30 dias</h3>
            <canvas id="pedidosChart" height="200"></canvas>
        </div>

        <div class="bg-white rounded-lg border p-6">
            <h3 class="font-medium mb-4">Distribuição por Status</h3>
            <canvas id="statusChart" height="200"></canvas>
        </div>

    </div>

    <div class="bg-white rounded-lg border overflow-hidden">
        <div class="p-6">
            <h3 class="font-medium mb-4">Pedidos Recentes</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Data</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pedidosRecentes as $pedido)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $pedido->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($pedido->data_pedido)->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                R$ {{ number_format($pedido->preco_total, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $pedido->status == 'Cancelado' ? 'bg-red-100 text-red-800' : 
                                       ($pedido->status == 'Entregue' ? 'bg-green-100 text-green-800' : 
                                       'bg-yellow-100 text-yellow-800') }}">
                                    {{ $pedido->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const pedidosCtx = document.getElementById('pedidosChart').getContext('2d');
const pedidosChart = new Chart(pedidosCtx, {
    type: 'bar',
    data: {
        labels: @json($pedidos30Dias->pluck('date')->map(fn($date) => Carbon\Carbon::parse($date)->format('d/m'))),
        datasets: [{
            label: 'Pedidos por dia',
            data: @json($pedidos30Dias -> pluck('total')),
            backgroundColor: 'rgba(245, 158, 11, 0.7)',
            borderColor: 'rgba(245, 158, 11, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});

const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: @json($statusPedidos->pluck('status')),
        datasets: [{
            data: @json($statusPedidos->pluck('total')),
            backgroundColor: [
                '#F59E0B', // Recebido
                '#3B82F6', // Em preparo
                '#10B981', // A caminho
                '#6366F1', // Entregue
                '#EF4444' // Cancelado
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'right'
            }
        }
    }
});
</script>
@endpush
@endsection