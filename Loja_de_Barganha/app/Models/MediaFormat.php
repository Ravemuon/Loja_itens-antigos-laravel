<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaFormat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'sigla',     // <-- novo campo
    ];

    // Relacionamento com itens (um formato pode ter muitos itens)
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}