<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'artista_diretor',
        'empresa_produtora',
        'elenco_detalhes',
        'quantidade_estoque',
        'preco',
        'capa',
        'descricao',
        'category_id',
        'user_id',
        'media_format_id',
    ];

    // Relacionamento 1:1 com a Ficha de Conservação
    public function condition()
    {
        return $this->hasOne(ItemCondition::class);
    }

    // Relacionamento N:1 (Muitos itens pertencem a uma categoria)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relacionamento N:1 (Muitos itens pertencem a um formato de mídia)
    public function mediaFormat()
    {
        return $this->belongsTo(MediaFormat::class);
    }

    // Relacionamento N:1 (Item pertence a um usuário)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento 1:N (Item tem muitas avaliações)
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function interestUsers()
    {
        return $this->belongsToMany(User::class, 'interests');
    }
    public function interests()
    {
        return $this->hasMany(Interest::class);
    }
}