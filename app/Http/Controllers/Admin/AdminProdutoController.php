<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\CategoriaProduto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AdminProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with('categoria')->latest()->paginate(10);
        return view('admin.produtos.index', compact('produtos'));
    }

    public function create()
    {
        $categorias = CategoriaProduto::all();
        $unidadesVenda = ['unidade', 'kg', 'litro', 'pacote', 'caixa', 'par', 'dz'];
        return view('admin.produtos.create', compact('categorias', 'unidadesVenda'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'categoria_id' => 'required|exists:categorias_produto,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric|min:0',
            'estoque' => 'required|integer|min:0',
            'unidade_venda' => 'required|in:un,kg,g,L,ml',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ativo' => 'nullable',
        ]);

        try {
            $imagemPath = null;
            
            if ($request->hasFile('imagem')) {
                
                $nomeImagem = Str::random(20) . '.' . $request->imagem->getClientOriginalExtension();
                $caminhoImagem = public_path('images');
                
                if (!file_exists($caminhoImagem)) {
                    mkdir($caminhoImagem, 0755, true);
                }

                try {
                    $request->imagem->move($caminhoImagem, $nomeImagem);
                    $imagemPath = 'images/' . $nomeImagem;
                } catch (\Exception $ex) {
                    throw $ex;
                }
            }

            $dadosProduto = [
                'categoria_id' => $request->categoria_id,
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'preco' => $request->preco,
                'estoque' => $request->estoque,
                'unidade_venda' => $request->unidade_venda,
                'imagem' => $imagemPath,
                'ativo' => $request->has('ativo') ? 1 : 0,
            ];

            $produto = Produto::create($dadosProduto);
            
            return redirect()->route('admin.produtos.index')
                ->with('success', 'Produto criado com sucesso!');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erro ao criar produto. Detalhes: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        $categorias = CategoriaProduto::all();
        $unidadesVenda = ['unidade', 'kg', 'litro', 'pacote', 'caixa', 'par', 'dz'];
        return view('admin.produtos.edit', compact('produto', 'categorias', 'unidadesVenda'));
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        $request->validate([
            'categoria_id' => 'required|exists:categorias_produto,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric|min:0',
            'estoque' => 'required|integer|min:0',
            'unidade_venda' => 'required|in:un,kg,g,L,ml',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ativo' => 'nullable',
        ]);

        $data = [
            'categoria_id' => $request->categoria_id,
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'estoque' => $request->estoque,
            'unidade_venda' => $request->unidade_venda,
            'ativo' => $request->has('ativo') ? 1 : 0,
        ];

        if ($request->hasFile('imagem')) {
            if ($produto->imagem && file_exists(public_path($produto->imagem))) {
                unlink(public_path($produto->imagem));
            }

            $nomeImagem = Str::random(20) . '.' . $request->imagem->getClientOriginalExtension();
            $request->imagem->move(public_path('images'), $nomeImagem);
            $data['imagem'] = 'images/' . $nomeImagem;
        }

        $produto->update($data);

        return redirect()->route('admin.produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);

        if ($produto->itensPedido()->count() > 0) {
            return back()->with('error', 'Não é possível excluir este produto porque ele está associado a pedidos.');
        }

        if ($produto->imagem && file_exists(public_path($produto->imagem))) {
            unlink(public_path($produto->imagem));
        }

        $produto->delete();

        return redirect()->route('admin.produtos.index')
            ->with('success', 'Produto removido com sucesso!');
    }

    public function relatorio()
    {
        $totalProdutos = Produto::count();
        $produtosSemEstoque = Produto::where('estoque', 0)->count();
        $produtosAtivos = Produto::where('ativo', true)->count();
        $produtosInativos = Produto::where('ativo', false)->count();
        
        $produtosPorCategoria = CategoriaProduto::withCount('produtos')
            ->orderBy('produtos_count', 'desc')
            ->get();
        
        $produtosMaisVendidos = Produto::withCount('itensPedido')
            ->orderBy('itens_pedido_count', 'desc')
            ->limit(5)
            ->get();
        
        $produtosPorMes = Produto::select(
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
        
        return view('admin.produtos.relatorio', compact(
            'totalProdutos',
            'produtosSemEstoque',
            'produtosAtivos',
            'produtosInativos',
            'produtosPorCategoria',
            'produtosMaisVendidos',
            'produtosPorMes'
        ));
    }
}