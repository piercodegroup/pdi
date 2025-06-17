<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cartoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->enum('tipo', ['Crédito', 'Débito']);
            $table->string('apelido');
            $table->string('nome_titular');
            $table->enum('bandeira', ['VISA', 'Mastercard']);
            $table->string('numero', 16);
            $table->date('data_validade');
            $table->string('cvv', 4);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cartoes');
    }
};