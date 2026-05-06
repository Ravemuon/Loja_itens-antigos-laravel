<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCondition extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'estado_caixa', 'estado_midia', 'possui_manual', 'detalhes_teste'];

    // OBS PARA APRESENTAÇÃO: Relacionamento 1:1 (Inverso). Esta ficha pertence a um único item específico.
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}