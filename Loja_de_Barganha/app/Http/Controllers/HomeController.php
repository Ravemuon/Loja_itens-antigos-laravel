<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Review;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $tipoMidia = $request->input('tipo_midia');
        $sort = $request->input('sort', 'latest');

        // Frases de impacto
        $frases = [
            'De Matanza a Pokémon, a raridade que você procura.',
            'Mosh no corredor, nostalgia na prateleira.',
            'Selos, cartuchos e sangue e suor.',
            'Onde o punk rock encontra o PS1.',
            'Garimpo pesado, preço leve.',
            'Vinil, cartucho e sangue nos olhos.',
            'Colecionador não para, só respira.',
        ];
        $fraseDestaque = $frases[array_rand($frases)];

        // ========== GRÁFICO 1: DONUT (Distribuição por Categoria) ==========
        $statsCategorias = Category::withCount('items')->get();
        $coresDonut = ['#e6b800', '#b91c1c', '#2b9c4a', '#6c2e77', '#d97706', '#a0a0a0', '#1c1c1c'];

        $chartDonut = (new LarapexChart)->donutChart()
            ->setTitle('⚔️ ARSENAL UNDERGROUND')
            ->setSubtitle('Itens por categoria')
            ->addData($statsCategorias->pluck('items_count')->toArray())
            ->setLabels($statsCategorias->pluck('nome')->toArray())
            ->setColors($coresDonut)
            ->setHeight(320)
            ->setToolbar(true)
            ->setFontFamily('"Rock Salt", "Courier New", monospace');

        // ========== GRÁFICO 2: TIPO DE MÍDIA (Chart.js na view) ==========
        $tiposMidia = ['Música', 'Filme', 'Jogo', 'Outro'];

        $contagemPorTipo = Category::whereIn('tipo_midia', $tiposMidia)
            ->withCount('items')
            ->get()
            ->groupBy('tipo_midia')
            ->map(fn($group) => $group->sum('items_count'))
            ->toArray();

        $midiaData = array_map(fn($tipo) => $contagemPorTipo[$tipo] ?? 0, $tiposMidia);
        $midiaLabels = $tiposMidia;

        // Itens em destaque (aleatórios)
        $featuredItems = Item::inRandomOrder()->limit(4)->get();

        // Query principal de itens
        $itemsQuery = Item::with(['category'])
            ->when($search, function ($q) use ($search) {
                return $q->where('titulo', 'like', "%{$search}%")
                         ->orWhere('artista_diretor', 'like', "%{$search}%");
            })
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->when($tipoMidia, fn($q) => $q->whereHas('category', fn($cq) => $cq->where('tipo_midia', $tipoMidia)));

        // Ordenação
        switch ($sort) {
            case 'price_asc': $itemsQuery->orderBy('preco', 'asc'); break;
            case 'price_desc': $itemsQuery->orderBy('preco', 'desc'); break;
            default: $itemsQuery->latest(); break;
        }

        $items = $itemsQuery->paginate(9);
        $categories = Category::all();

        // Últimos reviews (5)
        $recentReviews = Review::with(['user', 'item'])->latest()->take(5)->get();

        return view('welcome', compact(
            'items', 'categories', 'chartDonut', 'recentReviews',
            'search', 'categoryId', 'tipoMidia', 'featuredItems', 'sort',
            'fraseDestaque', 'midiaLabels', 'midiaData'
        ));
    }
}