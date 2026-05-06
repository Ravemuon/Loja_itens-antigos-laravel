<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Interest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InterestController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $user = auth()->user();

        $query = Interest::with(['item', 'user']);

        // Se não for admin, mostra apenas os interesses do próprio usuário
        if (!$user->is_admin) {
            $query->where('user_id', $user->id);
        }

        if ($search) {
            $query->whereHas('item', function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('artista_diretor', 'like', "%{$search}%");
            });
        }

        $interests = $query->latest()->paginate(15);
        $pendentesCount = Interest::where('status', 'pendente')->count();

        return view('interests.index', compact('interests', 'search', 'pendentesCount'));
    }

    /**
     * Exibe os detalhes de um interesse (show).
     */
    public function show(Interest $interest)
    {
        // Verifica permissão: dono do interesse ou admin
        if (auth()->id() !== $interest->user_id && !auth()->user()->is_admin) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('interests.show', compact('interest'));
    }

    /**
     * Exibe o formulário de edição de um interesse.
     */
    public function edit(Interest $interest)
    {
        // Verifica permissão: dono do interesse ou admin
        if (auth()->id() !== $interest->user_id && !auth()->user()->is_admin) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('interests.edit', compact('interest'));
    }

    public function create(Item $item)
    {
        // Verifica se o item existe (opcional, o Laravel já faz isso pelo ID na rota)
        if (!$item) {
            abort(404);
        }

        $existing = $item->interests()
            ->where('user_id', auth()->id())
            ->whereIn('status', ['pendente', 'alugado'])
            ->first();

        if ($existing) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Você já manifestou interesse neste item.');
        }

        return view('interests.create', compact('item'));
    }

    public function store(Request $request, Item $item)
    {
        $request->validate([
            'data_retirada'  => 'nullable|date',
            'data_devolucao' => 'nullable|date|after_or_equal:data_retirada',
        ]);

        $exists = $item->interests()
            ->where('user_id', auth()->id())
            ->whereIn('status', ['pendente', 'alugado'])
            ->exists();

        if ($exists) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Você já tem um interesse ativo para este item.');
        }

        $item->interests()->create([
            'user_id'        => auth()->id(),
            'status'         => 'pendente',
            'ip_address'     => $request->ip(),
            'data_retirada'  => $request->data_retirada,
            'data_devolucao' => $request->data_devolucao,
        ]);

        return redirect()->route('items.show', $item)
            ->with('success', 'Interesse registrado! Entraremos em contato.');
    }

    public function update(Request $request, Interest $interest)
    {
        // Só o dono do interesse ou admin pode atualizar
        if (auth()->id() !== $interest->user_id && !auth()->user()->is_admin) {
            return redirect()->back()->with('error', 'Você não pode editar este interesse.');
        }

        $request->validate([
            'data_retirada'  => 'nullable|date',
            'data_devolucao' => 'nullable|date|after_or_equal:data_retirada',
        ]);

        $data = $request->only(['data_retirada', 'data_devolucao']);

        // Se for admin, também pode alterar o status
        if (auth()->user()->is_admin && $request->has('status')) {
            $request->validate(['status' => 'required|in:pendente,alugado,devolvido,cancelado']);
            $data['status'] = $request->status;
        }

        $interest->update($data);

        // Redireciona de volta para a página de listagem (ou poderia ir para show)
        return redirect()->route('interests.index')
            ->with('success', 'Interesse atualizado com sucesso.');
    }

    public function destroy(Interest $interest)
    {
        if (auth()->id() !== $interest->user_id && !auth()->user()->is_admin) {
            return redirect()->back()->with('error', 'Ação não permitida.');
        }

        $interest->delete();
        return redirect()->back()->with('success', 'Interesse cancelado.');
    }

    public function generatePDF(Request $request)
    {
        $search = $request->input('search');
        
        $query = Interest::with(['item', 'user']);
        if ($search) {
            $query->whereHas('item', function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%");
            });
        }
        $interests = $query->latest()->get();

        $pdf = Pdf::loadView('relatorios.interests_pdf', compact('interests'));

        return $pdf->download('relatorio-interesses.pdf');
    }
}