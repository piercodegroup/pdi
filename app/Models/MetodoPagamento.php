<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPagamento extends Model
{
    use HasFactory;

    protected $table = 'metodos_pagamento';
    protected $fillable = ['nome', 'descricao'];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'metodo_pagamento_id');
    }
}