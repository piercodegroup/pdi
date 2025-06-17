<?php

namespace App\Http\Controllers;


use App\Models\Produto;
use App\Models\CategoriaProduto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $categorias = CategoriaProduto::all();
        $produtos = Produto::with('categoria')->paginate(12);
        
        return view('produtos.index', compact('produtos', 'categorias'));
    }

    public function show($id)
    {
        $produto = Produto::with('categoria')->findOrFail($id);
        $relacionados = Produto::where('categoria_id', $produto->categoria_id)
                            ->where('id', '!=', $produto->id)
                            ->limit(4)
                            ->get();
        
        return view('produtos.show', compact('produto', 'relacionados'));
    }
}