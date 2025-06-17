<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';
    protected $fillable = [
        'categoria_id',
        'nome',
        'descricao',
        'preco',
        'estoque',
        'unidade_venda',
        'imagem',
        'ativo'
    ];

    protected $casts = [    
        'preco' => 'decimal:2',
        'ativo' => 'boolean'
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaProduto::class, 'categoria_id');
    }

    public function itensSacola()
    {
        return $this->hasMany(ItensSacola::class, 'sacola_id');
    }

    public function itensPedido()
    {
        return $this->hasMany(ItensPedido::class, 'pedido_id');
    }
}