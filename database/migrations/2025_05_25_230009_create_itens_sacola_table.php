<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('itens_sacola', function (Blueprint $table) {
            $table->id();
            
            // Usando o nome correto da tabela de produtos
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
            
            // Corrigindo para usar 'sacola' em vez de 'sacolas'
            $table->foreignId('sacola_id')->constrained('sacola')->onDelete('cascade');
            
            $table->integer('quantidade');
            $table->decimal('subtotal', 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('itens_sacola');
    }
};