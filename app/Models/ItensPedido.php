<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItensPedido extends Model
{
    protected $table = 'itens_pedido';
    
    protected $fillable = [
        'produto_id',
        'pedido_id',
        'quantidade',
        'subtotal'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}