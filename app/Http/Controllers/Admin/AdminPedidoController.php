<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Sacola;
use App\Models\Endereco;
use App\Models\Cartao;
use App\Models\MetodoPagamento;
use App\Models\Produto;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminPedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'itens.produto'])
            ->latest()
            ->paginate(10);
            
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Pedido::with(['cliente', 'itens.produto', 'endereco'])
            ->findOrFail($id);
            
        return view('admin.pedidos.show', compact('pedido'));
    }

    public function atualizarStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Recebido,Em preparo,A caminho,Entregue,Cancelado'
        ]);
        
        $pedido = Pedido::findOrFail($id);
        $pedido->status = $request->status;
        $pedido->save();
        
        return back()->with('success', 'Status do pedido atualizado!');
    }

    public function relatorio()
    {
        $pedidos30Dias = Pedido::selectRaw('DATE(data_pedido) as date, COUNT(*) as total')
            ->where('data_pedido', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $statusPedidos = Pedido::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();
            
        $totalVendas = Pedido::where('status', '!=', 'Cancelado')
            ->sum('preco_total');
            
        $pedidosRecentes = Pedido::latest()->take(5)->get();
        
        return view('admin.pedidos.relatorio', compact(
            'pedidos30Dias',
            'statusPedidos',
            'totalVendas',
            'pedidosRecentes'
        ));
    }

    




    public function create()
    {
        $clientes = Cliente::all();
        $produtos = Produto::with('categoria')->paginate(12);
        $metodosPagamento = MetodoPagamento::all();
        
        return view('admin.pedidos.create', compact(
            'clientes',
            'produtos',
            'metodosPagamento'
        ));
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'produtos' => 'required|array|min:1',
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
            'metodo_pagamento_id' => 'required|exists:metodos_pagamento,id',
            'endereco_id' => 'required|exists:enderecos,id,cliente_id,'.$request->cliente_id,
            'cartao_id' => 'required_if:metodo_pagamento_id,1|nullable|exists:cartoes,id,cliente_id,'.$request->cliente_id,
            'troco' => 'required_if:metodo_pagamento_id,2|nullable|numeric|min:0',
            'status' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $cliente = Cliente::findOrFail($request->cliente_id);
            
            foreach ($request->produtos as $item) {
                $produto = Produto::findOrFail($item['id']);
                if ($produto->estoque < $item['quantidade']) {
                    throw new \Exception("Estoque insuficiente para o produto: {$produto->nome}");
                }
            }
            
            $pedido = new Pedido();
            $pedido->cliente_id = $cliente->id;
            $pedido->endereco_id = $request->endereco_id;
            $pedido->metodo_pagamento_id = $request->metodo_pagamento_id;
            
            if ($request->metodo_pagamento_id == 1) {
                $pedido->cartao_id = $request->cartao_id;
            }
            
            if ($request->metodo_pagamento_id == 2) {
                $pedido->troco = $request->troco;
            }
            
            $pedido->status = $request->status;
            $pedido->data_pedido = now();
            $pedido->data_entrega = now()->addHours(2);
            
            $total = 0;
            foreach ($request->produtos as $item) {
                $produto = Produto::find($item['id']);
                $total += $produto->preco * $item['quantidade'];
            }
            
            $pedido->preco_total = $total;
            $pedido->save();

            foreach ($request->produtos as $item) {
                $produto = Produto::find($item['id']);
                
                $pedido->itens()->create([
                    'produto_id' => $produto->id,
                    'quantidade' => $item['quantidade'],
                    'subtotal' => $produto->preco * $item['quantidade'],
                ]);

                $produto->estoque -= $item['quantidade'];
                $produto->save();
            }

            DB::commit();
            
            return redirect()->route('admin.pedidos.show', $pedido->id)
                ->with('success', 'Pedido criado com sucesso!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao criar pedido:', ['error' => $e->getMessage()]);
            return back()
                ->withInput()
                ->with('error', 'Erro ao criar pedido: ' . $e->getMessage());
        }
    }

}