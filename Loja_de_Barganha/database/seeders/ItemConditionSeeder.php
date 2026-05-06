<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\itemCondition;
use Illuminate\Database\Seeder;

class ItemConditionSeeder extends Seeder
{
    public function run(): void
    {
        // Buscamos todos os itens que ainda não possuem uma ficha de conservação
        $items = Item::doesntHave('condition')->get();

        foreach ($items as $item) {
            // Lógica para diversificar os dados nos gráficos e relatórios
            if ($item->tipo_midia === 'Jogo') {
                $item->condition()->create([
                    'estado_caixa' => 'Com marcas de uso',
                    'estado_midia' => 'Perfeita',
                    'possui_manual' => true,
                    'detalhes_teste' => 'Testado no console original. Funcionando e salvando perfeitamente.',
                ]);
            } elseif ($item->tipo_midia === 'Música') {
                $item->condition()->create([
                    'estado_caixa' => 'Perfeita',
                    'estado_midia' => 'Perfeita',
                    'possui_manual' => false,
                    'detalhes_teste' => 'Vinil higienizado. Sem pulos ou estalos significativos.',
                ]);
            } else {
                // Padrão para Filmes/Outros
                $item->condition()->create([
                    'estado_caixa' => 'Sem caixa',
                    'estado_midia' => 'Riscos leves',
                    'possui_manual' => false,
                    'detalhes_teste' => 'Reprodução testada até o final em player comum.',
                ]);
            }
        }
    }
}