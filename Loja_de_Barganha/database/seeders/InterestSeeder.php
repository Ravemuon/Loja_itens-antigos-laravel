<?php

namespace Database\Seeders;

use App\Models\Interest;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InterestSeeder extends Seeder
{
    /**
     * Alimenta a tabela de interesses/barganhas.
     * OBS: As datas são geradas retroativamente para simular um histórico real no PDF.
     */
    public function run(): void
    {
        $usuario = User::first(); // Assume que você já rodou o UserSeeder
        $itens = Item::all();

        if ($itens->isEmpty()) {
            return;
        }

        // 1. Criando Interesses 'Pendentes' (Novas solicitações)
        Interest::create([
            'item_id' => $itens->random()->id,
            'user_id' => $usuario->id,
            'status' => 'pendente',
            'data_retirada' => null,
            'data_devolucao' => null,
        ]);

        // 2. Criando Interesses 'Alugados' (Itens que estão com o usuário agora)
        Interest::create([
            'item_id' => $itens->random()->id,
            'user_id' => $usuario->id,
            'status' => 'alugado',
            'data_retirada' => Carbon::now()->subDays(2), // Retirado há 2 dias
            'data_devolucao' => Carbon::now()->addDays(5), // Devolução prevista para o futuro
        ]);

        // 3. Criando Interesses 'Devolvidos' (Histórico completo)
        Interest::create([
            'item_id' => $itens->random()->id,
            'user_id' => $usuario->id,
            'status' => 'devolvido',
            'data_retirada' => Carbon::now()->subDays(15),
            'data_devolucao' => Carbon::now()->subDays(8), // Devolvido semana passada
        ]);

        // 4. Criando Interesses 'Cancelados' (Para diversificar o gráfico)
        Interest::create([
            'item_id' => $itens->random()->id,
            'user_id' => $usuario->id,
            'status' => 'cancelado',
            'data_retirada' => null,
            'data_devolucao' => null,
        ]);
    }
}