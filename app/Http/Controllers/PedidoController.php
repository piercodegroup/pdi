<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Sacola;
use App\Models\Endereco;
use App\Models\Cartao;
use App\Models\MetodoPagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{

    public function index()
    {
        $pedidos = Auth::guard('cliente')->user()->pedidos()
            ->with('itens.produto')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pedidos.index', compact('pedidos'));
    }

    public function show($id)
    {
        $pedido = Auth::guard('cliente')->user()->pedidos()
            ->with(['itens.produto', 'endereco', 'cartao', 'metodoPagamento'])
            ->findOrFail($id);

        return view('pedidos.show', compact('pedido'));
    }

    public function confirmar()
    {
        $cliente = Auth::guard('cliente')->user();
        $sacola = $cliente->sacolaAtiva;
        
        if (!$sacola || $sacola->itens->isEmpty()) {
            return redirect()->route('sacola.index')->with('error', 'Sua sacola está vazia');
        }

        $enderecos = $cliente->enderecos;
        $cartoes = $cliente->cartoes;
        $metodosPagamento = MetodoPagamento::all();

        return view('pedidos.confirmar', compact(
            'sacola',
            'enderecos',
            'cartoes',
            'metodosPagamento'
        ));
    }

    public function finalizar(Request $request)
    {
        $request->validate([
            'endereco_id' => 'required|exists:enderecos,id',
            'metodo_pagamento_id' => 'required|exists:metodos_pagamento,id',
            'cartao_id' => 'nullable',
            'troco' => 'nullable',
        ]);

        $cliente = Auth::guard('cliente')->user();
        $sacola = $cliente->sacolaAtiva;

        if (!$sacola || $sacola->itens->isEmpty()) {
            return redirect()->route('sacola.index')->with('error', 'Sua sacola está vazia');
        }

        $pedido = new Pedido();
        $pedido->cliente_id = $cliente->id;
        $pedido->endereco_id = $request->endereco_id;
        $pedido->metodo_pagamento_id = $request->metodo_pagamento_id;
        $pedido->cartao_id = $request->cartao_id ?? null;
        $pedido->preco_total = $sacola->calcularTotal();
        $pedido->troco = $request->troco ?? null;
        $pedido->status = 'Aguardando confirmação da loja';
        $pedido->data_pedido = now();
        $pedido->data_entrega = now()->addHours(2);
        $pedido->save();

        foreach ($sacola->itens as $item) {
            $pedido->itens()->create([
                'produto_id' => $item->produto_id,
                'quantidade' => $item->quantidade,
                'subtotal' => $item->subtotal,
            ]);

            $produto = $item->produto;
            $produto->estoque -= $item->quantidade;
            $produto->save();
        }

        $sacola->itens()->delete();
        $sacola->status = 'Pedido finalizado';
        $sacola->save();

        return redirect()->route('pedidos.show', $pedido->id)
            ->with('success', 'Pedido realizado com sucesso!');
    }
}