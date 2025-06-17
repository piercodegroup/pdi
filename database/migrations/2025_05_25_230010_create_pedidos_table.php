<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('endereco_id')->constrained('enderecos')->onDelete('cascade');
            $table->foreignId('metodo_pagamento_id')->constrained('metodos_pagamento')->onDelete('cascade');
            $table->foreignId('cartao_id')->constrained('cartoes')->onDelete('cascade');
            $table->decimal('preco_total', 8, 2);
            $table->decimal('troco', 8, 2)->nullable();
            $table->enum('status', [
                'Aguardando confirmação da loja',
                'Em preparo',
                'A caminho',
                'Entregue',
                'Finalizado',
                'Cancelado'
            ])->default('Aguardando confirmação da loja');
            $table->dateTime('data_pedido');
            $table->dateTime('data_entrega');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
};