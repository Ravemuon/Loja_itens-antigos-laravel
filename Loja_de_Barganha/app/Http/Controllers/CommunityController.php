<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Item;
use App\Models\Interest;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    /**
     * Página principal da comunidade - mostra todas as reviews
     */
    public function index(Request $request)
    {
        $tipo = $request->input('tipo', 'recentes');
        
        $reviews = Review::with(['user', 'item'])
            ->when($tipo == 'top', function($q) {
                return $q->orderBy('nota', 'desc');
            })
            ->when($tipo == 'recentes', function($q) {
                return $q->latest();
            })
            ->paginate(12);
        
        $totalReviews = Review::count();
        $totalUsers = User::count();
        $totalItems = Item::count();
        $mediaGeral = Review::avg('nota') ?? 0;
        
        $topUsers = User::withCount('reviews')
            ->orderBy('reviews_count', 'desc')
            ->limit(5)
            ->get();
        
        // Distribuição de notas
        $notasDistribuicao = [
            1 => Review::where('nota', 1)->count(),
            2 => Review::where('nota', 2)->count(),
            3 => Review::where('nota', 3)->count(),
            4 => Review::where('nota', 4)->count(),
            5 => Review::where('nota', 5)->count(),
        ];
        
        // Itens para avaliar (mantido)
        $itensParaAvaliar = collect();
        if (auth()->check()) {
            $interestsIds = Interest::where('user_id', auth()->id())
                ->whereIn('status', ['pendente', 'alugado'])
                ->pluck('item_id')
                ->unique();
            
            $reviewedIds = Review::where('user_id', auth()->id())
                ->pluck('item_id');
            
            $itensParaAvaliar = Item::whereIn('id', $interestsIds)
                ->whereNotIn('id', $reviewedIds)
                ->get();
            
            if ($itensParaAvaliar->isEmpty()) {
                $itensParaAvaliar = Item::whereNotIn('id', $reviewedIds)
                    ->inRandomOrder()
                    ->limit(4)
                    ->get();
            }
        }
        
        return view('communities.index', compact(
            'reviews', 'totalReviews', 'totalUsers', 
            'totalItems', 'mediaGeral', 'topUsers', 'tipo',
            'itensParaAvaliar', 'notasDistribuicao'
        ));
    }
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validação da imagem
        ]);

        $data = $request->only('name');

        if ($request->hasFile('image')) {
            // Remove a imagem antiga se existir para não acumular lixo no servidor
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            // Salva a nova imagem na pasta 'profiles' dentro de 'storage/app/public'
            $path = $request->file('image')->store('profiles', 'public');
            $data['image'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Perfil de um usuário específico (com reviews e interesses)
     */
    public function profile(User $user)
    {
        $reviews = $user->reviews()->with('item')->latest()->paginate(10);
        $totalReviews = $user->reviews()->count();
        $mediaNota = $user->reviews()->avg('nota') ?? 0;
        
        // Buscar interesses do usuário (visível apenas para o próprio ou admin)
        $interesses = collect();
        $totalInteresses = 0;
        if (auth()->check() && (auth()->id() === $user->id || auth()->user()->is_admin)) {
            $interesses = Interest::where('user_id', $user->id)
                ->with('item')
                ->latest()
                ->paginate(10);
            $totalInteresses = $interesses->total();
        }
        
        // Para as estatísticas do cabeçalho: quantidade de itens avaliados (únicos)
        $totalItemsAvaliados = $user->reviews()->distinct('item_id')->count('item_id');
        
        return view('communities.profile', compact(
            'user', 'reviews', 'totalReviews', 'mediaNota',
            'interesses', 'totalInteresses', 'totalItemsAvaliados'
        ));
    }
    
    /**
     * Página de uma review específica
     */
    public function showReview(Review $review)
    {
        $review->load(['user', 'item']);
        
        $outrasReviews = Review::where('item_id', $review->item_id)
            ->where('id', '!=', $review->id)
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();
        
        return view('communities.review', compact('review', 'outrasReviews'));
    }
}