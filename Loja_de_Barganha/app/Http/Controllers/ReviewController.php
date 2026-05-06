<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Construtor: aplica middleware de autenticação.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Exibe a lista de avaliações do usuário autenticado.
     */
    public function index()
    {
        $reviews = Review::with('item')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Mostra os detalhes de uma avaliação específica (pública).
     */
    public function show(Review $review)
    {
        return view('reviews.show', compact('review'));
    }

    /**
     * Formulário específico para avaliar um item a partir do seu ID.
     * Verifica se o usuário tem interesse e ainda não avaliou.
     */
  /**
     * Exibe o formulário de criação de avaliação para um item específico.
     */
    public function create(Item $item)
    {
        $user = Auth::user();

        // Só permite se houver interesse registrado
        $hasInterest = $user->interests()->where('item_id', $item->id)->exists();
        if (!$hasInterest) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Você só pode avaliar itens que manifestou interesse.');
        }

        // Só permite se ainda não houver avaliação deste usuário para este item
        $alreadyReviewed = Review::where('user_id', $user->id)
            ->where('item_id', $item->id)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Você já avaliou este item.');
        }

        // Retorna a view padrão 'reviews.create'
        return view('reviews.create', compact('item'));
    }

    /**
     * Salva uma nova avaliação para um item específico.
     */
    public function store(Request $request, Item $item)
    {
        $request->validate([
            'nota'       => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|min:5|max:1000',
        ]);

        $user = Auth::user();

        // Segurança extra no backend
        if (!$user->interests()->where('item_id', $item->id)->exists()) {
            return back()->with('error', 'Você só pode avaliar itens que tem interesse.');
        }

        if (Review::where('user_id', $user->id)->where('item_id', $item->id)->exists()) {
            return back()->with('error', 'Você já avaliou este item.');
        }

        $item->reviews()->create([
            'user_id'    => $user->id,
            'nota'       => $request->nota,
            'comentario' => $request->comentario,
        ]);

        return redirect()->route('communities.index')
            ->with('success', 'Avaliação publicada na comunidade!');
    }

    /**
     * Exibe o formulário de edição da avaliação.
     */
    public function edit(Review $review)
    {
        if (Auth::id() !== $review->user_id) {
            abort(403, 'Você não pode editar esta avaliação.');
        }

        return view('reviews.edit', compact('review'));
    }

    /**
     * Atualiza a avaliação no banco de dados.
     */
    public function update(Request $request, Review $review)
    {
        if (Auth::id() !== $review->user_id) {
            abort(403, 'Você não pode editar esta avaliação.');
        }

        $request->validate([
            'nota'       => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|min:5|max:1000',
        ]);

        $review->update($request->only(['nota', 'comentario']));

        return redirect()->route('reviews.index')
            ->with('success', 'Avaliação atualizada com sucesso!');
    }

    /**
     * Remove a avaliação do banco de dados.
     */
    public function destroy(Review $review)
    {
        if (Auth::id() !== $review->user_id) {
            abort(403, 'Você não pode excluir esta avaliação.');
        }

        $review->delete();

        return redirect()->route('reviews.index')
            ->with('success', 'Avaliação removida com sucesso.');
    }
}