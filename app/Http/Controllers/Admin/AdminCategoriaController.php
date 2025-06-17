<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoriaProduto;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AdminCategoriaController extends Controller
{
    public function index()
    {
        $categorias = CategoriaProduto::latest()->paginate(10);
        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:categorias_produto,nome',
            'descricao' => 'nullable|string',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imagemPath = null;
            
            if ($request->hasFile('imagem')) {
                $nomeImagem = Str::random(20) . '.' . $request->imagem->getClientOriginalExtension();
                $caminhoImagem = public_path('images/categorias');
                
                if (!file_exists($caminhoImagem)) {
                    mkdir($caminhoImagem, 0755, true);
                }

                $request->imagem->move($caminhoImagem, $nomeImagem);
                $imagemPath = 'images/categorias/' . $nomeImagem;
            }

            $dadosCategoria = [
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'imagem' => $imagemPath,
            ];

            CategoriaProduto::create($dadosCategoria);
            
            return redirect()->route('admin.categorias.index')
                ->with('success', 'Categoria criada com sucesso!');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erro ao criar categoria. Detalhes: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $categoria = CategoriaProduto::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $categoria = CategoriaProduto::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255|unique:categorias_produto,nome,'.$id,
            'descricao' => 'nullable|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ];

        if ($request->hasFile('imagem')) {
            if ($categoria->imagem && file_exists(public_path($categoria->imagem))) {
                unlink(public_path($categoria->imagem));
            }

            $nomeImagem = Str::random(20) . '.' . $request->imagem->getClientOriginalExtension();
            $request->imagem->move(public_path('images/categorias'), $nomeImagem);
            $data['imagem'] = 'images/categorias/' . $nomeImagem;
        }

        $categoria->update($data);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $categoria = CategoriaProduto::findOrFail($id);

        if ($categoria->produtos()->count() > 0) {
            return back()->with('error', 'Não é possível excluir esta categoria porque ela possui produtos associados.');
        }

        if ($categoria->imagem && file_exists(public_path($categoria->imagem))) {
            unlink(public_path($categoria->imagem));
        }

        $categoria->delete();

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria removida com sucesso!');
    }

    public function relatorio()
    {
        $totalCategorias = CategoriaProduto::count();
        $categoriasComProdutos = CategoriaProduto::has('produtos')->count();
        $categoriasSemProdutos = $totalCategorias - $categoriasComProdutos;
        
        $categoriasMaisProdutos = CategoriaProduto::withCount('produtos')
            ->orderBy('produtos_count', 'desc')
            ->limit(5)
            ->get();
        
        $categoriasPorMes = CategoriaProduto::select(
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
        
        return view('admin.categorias.relatorio', compact(
            'totalCategorias',
            'categoriasComProdutos',
            'categoriasSemProdutos',
            'categoriasMaisProdutos',
            'categoriasPorMes'
        ));
    }
}