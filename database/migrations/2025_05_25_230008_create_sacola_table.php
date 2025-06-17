<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sacola', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->enum('status', [
                'Aguardando Confirmação',
                'Em andamento',
                'Pagamento confirmado',
                'Preparando pedido',
                'Pedido finalizado',
                'Saiu para entrega',
                'Chegou ao destino final'
            ])->default('Aguardando Confirmação');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sacola');
    }
};