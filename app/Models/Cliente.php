<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cliente extends Authenticatable {

    use HasFactory;

    protected $table = 'clientes';
    protected $fillable = ['nome', 'email', 'senha', 'telefone', 'cpf'];
    protected $hidden = ['senha', 'remember_token']; // Adicionei remember_token

    public function enderecos()
    {
        return $this->hasMany(Endereco::class, 'cliente_id');
    }

    public function cartoes()
    {
        return $this->hasMany(Cartao::class, 'cliente_id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function sacola()
    {
        return $this->hasMany(Sacola::class, 'cliente_id');
    }

    public function sacolaAtiva()
    {
        return $this->hasOne(Sacola::class, 'cliente_id')
            ->where('status', 'Em andamento')
            ->with('itens');
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }

}