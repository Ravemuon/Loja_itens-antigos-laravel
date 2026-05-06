<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\MediaFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function checkAdmin()
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'ACESSO NEGADO: Apenas administradores podem gerenciar itens.');
        }
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');

        $items = Item::with(['category', 'mediaFormat', 'condition'])
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('titulo', 'like', "%{$search}%")
                      ->orWhere('artista_diretor', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(12);

        $categories = Category::all();
        
        return view('items.index', compact('items', 'categories', 'search', 'categoryId'));
    }

    public function create()
    {
        $this->checkAdmin();
        $categories = Category::all();
        $formats = MediaFormat::all();
        return view('items.create', compact('categories', 'formats'));
    }

    public function store(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'titulo'             => 'required|min:2|max:255',
            'artista_diretor'    => 'nullable|string|max:255',
            'empresa_produtora'  => 'nullable|string|max:255',
            'elenco_detalhes'    => 'nullable|string',
            'descricao'          => 'nullable|string',
            'preco'              => 'required|numeric|min:0',
            'quantidade_estoque' => 'required|integer|min:0',
            'category_id'        => 'required|exists:categories,id',
            'media_format_id'    => 'required|exists:media_formats,id',
            'capa'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado_caixa'       => 'nullable|string|max:255',
            'estado_midia'       => 'nullable|string|max:255',
            'possui_manual'      => 'nullable|boolean',
            'detalhes_teste'     => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $data = $request->except(['_token', '_method', 'estado_caixa', 'estado_midia', 'possui_manual', 'detalhes_teste']);
                $data['user_id'] = auth()->id();

                if ($request->hasFile('capa')) {
                    $data['capa'] = $request->file('capa')->store('capas', 'public');
                }

                $item = Item::create($data);

                $item->condition()->create([
                    'estado_caixa'   => $request->estado_caixa ?? 'Sem caixa',
                    'estado_midia'   => $request->estado_midia ?? 'Perfeita',
                    'possui_manual'  => $request->has('possui_manual'),
                    'detalhes_teste' => $request->detalhes_teste ?? 'Sem observações.',
                ]);
            });

            return redirect()->route('items.index')->with('success', '🔥 Relíquia catalogada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao salvar: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, Item $item)
    {
        $this->checkAdmin();

        $request->validate([
            'titulo'             => 'required|min:2|max:255',
            'artista_diretor'    => 'nullable|string|max:255',
            'empresa_produtora'  => 'nullable|string|max:255',
            'elenco_detalhes'    => 'nullable|string',
            'descricao'          => 'nullable|string',
            'preco'              => 'required|numeric|min:0',
            'quantidade_estoque' => 'required|integer|min:0',
            'category_id'        => 'required|exists:categories,id',
            'media_format_id'    => 'required|exists:media_formats,id',
            'capa'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado_caixa'       => 'nullable|string|max:255',
            'estado_midia'       => 'nullable|string|max:255',
            'possui_manual'      => 'nullable|boolean',
            'detalhes_teste'     => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($request, $item) {
                $data = $request->except(['_token', '_method', 'estado_caixa', 'estado_midia', 'possui_manual', 'detalhes_teste']);

                if ($request->hasFile('capa')) {
                    if ($item->capa) Storage::disk('public')->delete($item->capa);
                    $data['capa'] = $request->file('capa')->store('capas', 'public');
                }

                $item->update($data);

                if ($item->condition) {
                    $item->condition->update([
                        'estado_caixa'   => $request->estado_caixa ?? 'Sem caixa',
                        'estado_midia'   => $request->estado_midia ?? 'Perfeita',
                        'possui_manual'  => $request->has('possui_manual'),
                        'detalhes_teste' => $request->detalhes_teste ?? 'Sem observações.',
                    ]);
                } else {
                    $item->condition()->create([
                        'estado_caixa'   => $request->estado_caixa ?? 'Sem caixa',
                        'estado_midia'   => $request->estado_midia ?? 'Perfeita',
                        'possui_manual'  => $request->has('possui_manual'),
                        'detalhes_teste' => $request->detalhes_teste ?? 'Sem observações.',
                    ]);
                }
            });

            return redirect()->route('items.show', $item)->with('success', '⚡ Relíquia atualizada!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = Item::with(['category', 'mediaFormat', 'condition'])->findOrFail($id);
        
        // Estatísticas das avaliações
        $reviews = $item->reviews()->with('user')->latest()->paginate(5); // ou ->get()
        $reviewsCount = $item->reviews()->count();
        $averageRating = $item->reviews()->avg('nota') ?? 0;
        
        // Distribuição das notas (para o gráfico)
        $ratingDistribution = [
            1 => $item->reviews()->where('nota', 1)->count(),
            2 => $item->reviews()->where('nota', 2)->count(),
            3 => $item->reviews()->where('nota', 3)->count(),
            4 => $item->reviews()->where('nota', 4)->count(),
            5 => $item->reviews()->where('nota', 5)->count(),
        ];
        
        return view('items.show', compact('item', 'reviews', 'reviewsCount', 'averageRating', 'ratingDistribution'));
    }
    public function edit(Item $item)
    {
        $this->checkAdmin();
        $categories = Category::all();
        $formats = MediaFormat::all();
        $item->load('condition');
        
        return view('items.edit', compact('item', 'categories', 'formats'));
    }

    public function destroy(Item $item)
    {
        $this->checkAdmin();

        try {
            DB::transaction(function () use ($item) {
                if ($item->capa) {
                    Storage::disk('public')->delete($item->capa);
                }
                $item->delete();
            });
            
            return redirect()->route('items.index')->with('success', '💀 Item removido do acervo!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao remover: ' . $e->getMessage());
        }
    }
}