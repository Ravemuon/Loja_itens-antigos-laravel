<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'user_id',
        'status',
        'data_retirada',
        'data_devolucao',
    ];

    protected $casts = [
        'data_retirada' => 'date',
        'data_devolucao' => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}