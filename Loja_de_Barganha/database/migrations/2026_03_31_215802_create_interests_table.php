<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('interests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            // Adicionado para suportar a lógica do seu Controller
            $table->string('ip_address', 45)->nullable(); 
            
            $table->enum('status', ['pendente', 'alugado', 'devolvido', 'cancelado'])->default('pendente');
            
            $table->date('data_retirada')->nullable();
            $table->date('data_devolucao')->nullable();
            
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interests');
    }
};