<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    
    protected $fillable = [
        'cliente_id',
        'endereco_id',
        'metodo_pagamento_id',
        'cartao_id',
        'preco_total',
        'troco',
        'status',
        'data_pedido',
        'data_entrega'
    ];
    
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    
    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }
    
    public function metodoPagamento()
    {
        return $this->belongsTo(MetodoPagamento::class, 'metodo_pagamento_id');
    }
    
    public function cartao()
    {
        return $this->belongsTo(Cartao::class);
    }
    
    public function itens()
    {
        return $this->hasMany(ItensPedido::class);
    }
    
}   