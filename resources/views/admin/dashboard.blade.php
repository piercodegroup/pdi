@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6 text-slate-700">Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <div class="bg-white border border-gray-200 rounded-lg p-6 text-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-medium">Total de Vendas</h3>
                    <p class="text-3xl font-bold mt-2">R$ {{ number_format($totalVendas, 2, ',', '.') }}</p>
                </div>
                <i class='bx bx-credit-card text-4xl text-color-primary opacity-20'></i>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                <span class="{{ $totalVendas > 0 ? 'text-green-500' : 'text-gray-500' }}">
                    <i class='bx bx-trending-up'></i> Últimos 30 dias
                </span>
            </div>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-lg p-6 text-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-medium">Pedidos Hoje</h3>
                    <p class="text-3xl font-bold mt-2">
                        {{ $data[count($data)-1] ?? 0 }}
                    </p>
                </div>
                <i class='bx bx-package text-4xl text-color-primary opacity-20'></i>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                {{ Carbon\Carbon::now()->format('d/m/Y') }}
            </div>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-lg p-6 text-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-medium">Pedidos em Andamento</h3>
                    <p class="text-3xl font-bold mt-2">
                        {{ $statusPedidos->whereIn('status', ['Em preparo', 'A caminho'])->sum('total') }}
                    </p>
                </div>
                <i class='bx bx-time-five text-4xl text-color-primary opacity-20'></i>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                Em preparação ou entrega
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white border border-gray-200 rounded-lg p-6 lg:col-span-2 h-[500px]">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-medium text-slate-700">Pedidos nos últimos 7 dias</h3>
                <div class="text-sm text-gray-500">
                    {{ Carbon\Carbon::now()->subDays(7)->format('d/m/Y') }} - {{ Carbon\Carbon::now()->format('d/m/Y') }}
                </div>
            </div>
            <canvas id="pedidosChart" class="p-10" height="80"></canvas>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h3 class="font-medium mb-4 text-slate-700">Status dos Pedidos</h3>
            <div class="space-y-4">
                @foreach($statusPedidos as $status)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>{{ $status->status }}</span>
                        <span>{{ $status->total }} ({{ round(($status->total/$statusPedidos->sum('total'))*100) }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-color-primary h-2 rounded-full" 
                             style="width: {{ ($status->total/$statusPedidos->sum('total'))*100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-medium text-slate-700">Pedidos Recentes</h3>
            <a href="{{ route('admin.pedidos.index') }}" class="text-sm text-color-primary hover:underline">
                Ver todos
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pedidosRecentes as $pedido)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $pedido->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pedido->cliente->nome }}</td>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('pedidosChart').getContext('2d');
        
        const chartData = @json($data).map(Number);
        
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Pedidos por dia',
                    data: chartData,
                    borderColor: '#F59E0B',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#F59E0B',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45, // ou 60
                            minRotation: 30, // evita que fique na horizontal
                            autoSkip: true,
                            maxTicksLimit: 5
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'nearest'
                }
            }
        });
    });
</script>
@endpush
@endsection