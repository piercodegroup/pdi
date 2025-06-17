<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias_produto');
            $table->string('nome');
            $table->text('descricao');
            $table->decimal('preco', 8, 2);
            $table->integer('estoque');
            $table->enum('unidade_venda', ['un', 'kg', 'g', 'L', 'ml']);
            $table->string('imagem');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
};