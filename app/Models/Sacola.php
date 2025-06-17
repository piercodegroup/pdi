<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sacola extends Model
{
    use HasFactory;

    protected $table = 'sacola';
    protected $fillable = ['cliente_id', 'status'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function itens()
    {
        return $this->hasMany(ItensSacola::class, 'sacola_id');
    }

    public function calcularTotal()
    {
        return $this->itens->sum('subtotal');
    }
}