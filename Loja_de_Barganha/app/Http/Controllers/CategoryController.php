<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Construtor: aplica middleware 'auth' apenas para os métodos de escrita.
     * Index e Show permanecem públicos (visitantes podem ver).
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Verifica se o usuário autenticado é administrador.
     * Usado internamente antes de qualquer operação de escrita.
     */
    private function checkAdmin()
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'ACESSO NEGADO: Você não tem autoridade de síndico do caos.');
        }
    }

    /**
     * Listagem pública de categorias (com busca e paginação).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = Category::withCount('items')
            ->when($search, function ($query, $search) {
                return $query->where('nome', 'like', "%{$search}%")
                             ->orWhere('tipo_midia', 'like', "%{$search}%");
            })
            ->paginate(12);

        return view('categories.index', compact('categories', 'search'));
    }

    /**
     * Exibe formulário para nova categoria – apenas admin.
     */
    public function create()
    {
        $this->checkAdmin();
        return view('categories.create');
    }

    /**
     * Salva nova categoria – apenas admin.
     */
    public function store(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'nome'         => 'required|unique:categories|max:255',
            'descricao'    => 'required|min:10',
            'tipo_midia'   => 'required|in:Música,Jogo,Filme,Outro',
            'publico_alvo' => 'required|max:50',
            'icone'        => 'nullable|string|max:50',
        ], [
            'nome.unique'   => 'Essa coleção já existe no nosso estoque!',
            'descricao.min' => 'A descrição precisa ser mais detalhada para o relatório.'
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Nova categoria catalogada com sucesso!');
    }

    /**
     * Exibe uma categoria específica (pública).
     */
    public function show(Category $category, Request $request)
    {
        $search = $request->input('search');

        $items = $category->items()
            ->with(['mediaFormat', 'condition'])
            ->when($search, function ($query, $search) {
                return $query->where('titulo', 'like', "%{$search}%")
                            ->orWhere('artista_diretor', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(12);

        // Dados para o gráfico
        $todosItens = $category->items()->with('mediaFormat')->get();
        $formatosCount = $todosItens
            ->groupBy(fn($item) => $item->mediaFormat->nome ?? 'Sem formato')
            ->map->count();

        // Prepara arrays para JavaScript
        $labels = $formatosCount->keys()->toArray();
        $data = $formatosCount->values()->toArray();

        return view('categories.show', compact('category', 'items', 'search', 'labels', 'data'));
    }

    /**
     * Formulário de edição – apenas admin.
     */
    public function edit(Category $category)
    {
        $this->checkAdmin();
        return view('categories.edit', compact('category'));
    }

    /**
     * Atualiza categoria – apenas admin.
     */
    public function update(Request $request, Category $category)
    {
        $this->checkAdmin();

        $request->validate([
            'nome'         => 'required|max:255|unique:categories,nome,' . $category->id,
            'descricao'    => 'required|min:10',
            'tipo_midia'   => 'required|in:Música,Jogo,Filme,Outro',
            'publico_alvo' => 'required|max:50',
            'icone'        => 'nullable|string|max:50',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Dados da categoria atualizados!');
    }

    /**
     * Remove categoria – apenas admin.
     */
    public function destroy(Category $category)
    {
        $this->checkAdmin();
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Categoria removida do sistema!');
    }
}