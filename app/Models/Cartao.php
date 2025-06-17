<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartao extends Model
{
    use HasFactory;

    protected $table = 'cartoes';

    protected $fillable = [
        'cliente_id',
        'tipo',
        'apelido',
        'nome_titular',
        'bandeira',
        'numero',
        'data_validade',
        'cvv',
    ];

    protected $casts = [
        'data_validade' => 'datetime:Y-m-d',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'cartao_id');
    }

    public function getDataValidadeFormatadaAttribute()
    {
        return $this->data_validade?->format('m/Y');
    }
}