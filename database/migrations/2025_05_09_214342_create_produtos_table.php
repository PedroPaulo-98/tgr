<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();//ID do Produto (OBS: certos casos posso implementar o UUID)
            $table->string('nome');//Nome do produto
            $table->string('descricao', 100)->nullable();//Descrição do produto, permitindo se seja nulo e delimitando em 100 
            $table->decimal('preco');//Preço eu sempre coloco como string 
            $table->integer('quantidade')->default(1);//Quantidade como inteiro, não permitindo colocar numeor quebrado ou podendo levar metade de um produto 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
