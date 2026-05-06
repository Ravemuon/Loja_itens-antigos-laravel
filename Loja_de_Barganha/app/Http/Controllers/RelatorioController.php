<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function gerarRelatorioItens(Request $request)
    {
        // Opcional: só admin pode gerar?
        // if (auth()->check() && auth()->user()->is_admin == false) {
        //     abort(403);
        // }

        $search = $request->input('search');
        $tipoMidia = $request->input('tipo_midia');
        $categoryId = $request->input('category_id');

        $items = Item::with(['category', 'mediaFormat', 'condition'])
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('titulo', 'like', "%{$search}%")
                      ->orWhere('artista_diretor', 'like', "%{$search}%")
                      ->orWhere('empresa_produtora', 'like', "%{$search}%");
                });
            })
            ->when($tipoMidia, function ($query, $tipoMidia) {
                return $query->where('tipo_midia', $tipoMidia);
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->latest()
            ->get(); // relatório geral (sem paginação)

        $data = [
            'items'        => $items,
            'search'       => $search,
            'tipoMidia'    => $tipoMidia,
            'generated_at' => now()->format('d/m/Y H:i:s'),
            'total_items'  => $items->count(),
        ];

        $pdf = Pdf::loadView('relatorios.itens_pdf', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('relatorio_estoque_underground.pdf');
    }
}