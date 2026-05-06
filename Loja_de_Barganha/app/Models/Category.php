<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'descricao', 'publico_alvo', 'tipo_midia'];

    // OBS PARA APRESENTAÇÃO: Relacionamento 1:N. Uma categoria possui muitos itens cadastrados.
    // Essencial para gerar gráficos de "Quantidade de itens por Categoria" no Larapex Charts.
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}