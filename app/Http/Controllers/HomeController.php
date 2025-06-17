<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProduto;
use App\Models\Produto;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categorias = CategoriaProduto::with('produtos')->get();
        $produtos = Produto::where('ativo', true)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
            
        return view('welcome', compact('categorias', 'produtos'));
    }
}