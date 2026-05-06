<?php

namespace App\Http\Controllers;

use App\Models\Item;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Contagem de itens por estado de conservação para o gráfico
        // Puxamos direto da relação 'condition'
        $dadosGerais = \App\Models\ItemCondition::selectRaw('estado_geral, count(*) as total')
            ->groupBy('estado_geral')
            ->pluck('total', 'estado_geral')
            ->toArray();

        $chart = (new LarapexChart)->pieChart()
            ->setTitle('Estado de Conservação do Acervo')
            ->setSubtitle('Distribuição física dos itens')
            ->addData(array_values($dadosGerais))
            ->setLabels(array_keys($dadosGerais))
            ->setColors(['#00ff00', '#ffbb00', '#ff0000', '#0000ff']); // Cores customizadas

        return view('dashboard', compact('chart'));
    }
}