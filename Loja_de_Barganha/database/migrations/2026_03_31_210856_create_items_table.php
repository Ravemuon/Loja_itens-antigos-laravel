<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            
            $table->string('artista_diretor')->nullable();
            $table->string('empresa_produtora')->nullable();
            $table->text('elenco_detalhes')->nullable();
            
            $table->integer('quantidade_estoque')->default(1); 
            $table->decimal('preco', 8, 2);
            $table->string('capa')->nullable(); 
            $table->text('descricao')->nullable();
            
            // Relacionamentos 1:N
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->foreignId('media_format_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};