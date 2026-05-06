<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            
            // OBS PARA APRESENTAÇÃO: CRUD de Categorias expandido com múltiplos campos de dados para validação.
            $table->string('nome')->unique();
            $table->text('descricao'); 
            $table->string('publico_alvo')->default('Livre'); // Ex: Livre, +18, +14
            $table->enum('tipo_midia', ['Música', 'Jogo', 'Filme', 'Outro']);
            $table->string('icone')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};