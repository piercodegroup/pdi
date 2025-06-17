<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $totalVendas = Pedido::where('status', '!=', 'Cancelado')
            ->sum('preco_total');

        $pedidos30Dias = Pedido::select(
                DB::raw('DATE(data_pedido) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('data_pedido', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();

        $labels = [];
        $data = [];
        
        for ($i = 7; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::now()->subDays($i)->format('d/m');
            $data[] = $pedidos30Dias[$date] ?? 0;
        }

        $statusPedidos = Pedido::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->orderBy('total', 'desc')
            ->get();

        $pedidosRecentes = Pedido::with('cliente')
            ->orderBy('data_pedido', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'labels', 
            'data', 
            'statusPedidos', 
            'totalVendas', 
            'pedidosRecentes'
        ));
    }
}