<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Qual item está sendo avaliado?
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            // Quem está avaliando?
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // OBS PARA APRESENTAÇÃO: O campo 'nota' será perfeito para gerar gráficos (Ex: Média de notas por Categoria).
            $table->integer('nota')->comment('Nota de 1 a 5');
            $table->text('comentario')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};