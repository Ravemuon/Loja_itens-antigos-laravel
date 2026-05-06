<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('item_conditions', function (Blueprint $table) {
            $table->id();
            
            // OBS PARA APRESENTAÇÃO (MUITO IMPORTANTE): 
            // O uso do ->unique() na chave estrangeira é o que garante a nível de banco de dados 
            // que o relacionamento seja estritamente 1:1. Um item não pode ter duas fichas.
            $table->foreignId('item_id')->unique()->constrained()->onDelete('cascade');
            
            // Campos do CRUD (Mais de 3 campos exigidos pelo PDF)
            $table->enum('estado_caixa', ['Perfeita', 'Com marcas de uso', 'Danificada', 'Sem caixa']);
            $table->enum('estado_midia', ['Perfeita', 'Riscos leves', 'Riscos profundos', 'Mofada']);
            $table->boolean('possui_manual')->default(false);
            $table->text('detalhes_teste')->nullable(); // Ex: "Fita testada no SNES dia 10/05, salvando normal"
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_conditions');
    }
};