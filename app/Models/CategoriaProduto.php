<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaProduto extends Model
{
    use HasFactory;

    protected $table = 'categorias_produto';
    protected $fillable = ['nome', 'descricao', 'imagem'];

    public function produtos()
    {
        return $this->hasMany(Produto::class, 'categoria_id');
    }
}