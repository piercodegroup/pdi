<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::latest()->paginate(10);
        return view('admin.clientes.index', compact('clientes'));
    }

    public function show($id)
    {
        $cliente = Cliente::withCount('pedidos')->findOrFail($id);
        return view('admin.clientes.show', compact('cliente'));
    }

    public function pedidos($id)
    {
        $cliente = Cliente::findOrFail($id);
        $pedidos = $cliente->pedidos()->latest()->paginate(10);
        
        return view('admin.clientes.pedidos', compact('cliente', 'pedidos'));
    }

    public function relatorio()
    {

        $totalClientes = Cliente::count();
        
        $novosClientesMes = Cliente::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $clientesAtivos = Cliente::has('pedidos')->count();
        
        $clientesPorMes = Cliente::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as total')
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get()
        ->map(function ($item) {
            return [
                'label' => Carbon::createFromDate($item->year, $item->month, 1)->format('M/Y'),
                'total' => $item->total
            ];
        });
        
        $topClientes = Cliente::withSum('pedidos', 'preco_total')
            ->orderBy('pedidos_sum_preco_total', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.clientes.relatorio', compact(
            'totalClientes',
            'novosClientesMes',
            'clientesAtivos',
            'clientesPorMes',
            'topClientes'
        ));

    }













    public function create()
    {
        return view('admin.clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes',
            'telefone' => 'nullable|string|max:20',
            'cpf' => 'required',
            'senha' => 'required|string|min:8|confirmed',
            'status' => 'required|in:ativo,inativo',
        ]);

        $cliente = Cliente::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'senha' => Hash::make($request->senha),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.clientes.show', $cliente->id)
            ->with('success', 'Cliente criado com sucesso!');
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'cpf' => 'required',
            'telefone' => 'nullable|string|max:20',
            'senha' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:ativo,inativo',
        ]);

        $data = [
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'cpf' => $request->cpf,
            'status' => $request->status,
        ];

        if ($request->filled('senha')) {
            $data['senha'] = Hash::make($request->senha);
        }

        $cliente->update($data);

        return redirect()->route('admin.clientes.show', $cliente->id)
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        
        if ($cliente->pedidos()->count() > 0) {
            return back()->with('error', 'Não é possível excluir este cliente porque ele possui pedidos associados.');
        }
        
        $cliente->enderecos()->delete();
        $cliente->cartoes()->delete();
        
        $cliente->delete();

        return redirect()->route('admin.clientes.index')
            ->with('success', 'Cliente removido com sucesso!');
    }



















    public function enderecos($id)
    {
        $cliente = Cliente::findOrFail($id);
        $enderecos = $cliente->enderecos;
        return view('admin.clientes.enderecos', compact('cliente', 'enderecos'));
    }

    public function cartoes($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cartoes = $cliente->cartoes;
        return view('admin.clientes.cartoes', compact('cliente', 'cartoes'));
    }

    public function removerEndereco($clienteId, $enderecoId)
    {
        $endereco = Endereco::where('cliente_id', $clienteId)
                        ->findOrFail($enderecoId);
        $endereco->delete();

        return back()->with('success', 'Endereço removido com sucesso!');
    }

    public function removerCartao($clienteId, $cartaoId)
    {
        $cartao = Cartao::where('cliente_id', $clienteId)
                    ->findOrFail($cartaoId);
        $cartao->delete();

        return back()->with('success', 'Cartão removido com sucesso!');
    }

}