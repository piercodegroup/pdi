<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItensSacola extends Model
{
    use HasFactory;

    protected $table = 'itens_sacola';
    protected $fillable = ['produto_id', 'sacola_id', 'quantidade', 'subtotal'];

    protected $casts = [
        'subtotal' => 'decimal:2'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }

    public function sacola()
    {
        return $this->belongsTo(Sacola::class, 'sacola_id');
    }
}