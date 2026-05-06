<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_formats', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique(); // Ex: Vinil, CD, Cartucho
            $table->string('sigla')->nullable()->unique(); // Ex: VINIL, CD, CART
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_formats');
    }
};