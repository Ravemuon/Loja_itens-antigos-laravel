@extends('layouts.app')

@section('title', 'Editar Interesse')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-white">
            <i class="bi bi-pencil-square text-warning me-2"></i> 
            EDITAR INTERESSE
        </h2>
        <a href="{{ route('interests.index') }}" class="btn-outline-rock">
            <i class="bi bi-arrow-left-circle"></i> VOLTAR
        </a>
    </div>

    <div class="card bg-dark border-secondary shadow">
        <div class="card-body p-4">
            <div class="row g-4">
                {{-- COLUDA ESQUERDA: DADOS DO ITEM (somente leitura) --}}
                <div class="col-md-5">
                    <div class="border-bottom border-danger pb-2 mb-3">
                        <h5 class="text-danger mb-0">
                            <i class="bi bi-vinyl-fill me-1"></i> ITEM RELACIONADO
                        </h5>
                    </div>
                    <div class="d-flex gap-3 align-items-start">
                        @if($interest->item->capa)
                            <img src="{{ asset('storage/' . $interest->item->capa) }}" 
                                 class="rounded border border-secondary" 
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="bg-black rounded border border-secondary d-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <i class="bi bi-vinyl text-dim fs-1"></i>
                            </div>
                        @endif
                        <div>
                            <h5 class="text-white mb-1">{{ $interest->item->titulo }}</h5>
                            <p class="text-danger mb-1">{{ $interest->item->artista_diretor }}</p>
                            <div class="d-flex gap-3 mt-2">
                                <span class="price-tag small text-warning fw-bold">
                                    R$ {{ number_format($interest->item->preco, 2, ',', '.') }}
                                </span>
                                <span class="badge bg-dark text-white border border-secondary px-2 py-1">
                                    {{ $interest->item->ano ?? 'Ano não informado' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top border-secondary">
                        <a href="{{ route('items.show', $interest->item->id) }}" class="btn btn-sm btn-outline-info mt-2" target="_blank">
                            <i class="bi bi-box-arrow-up-right"></i> VER ITEM NA VITRINE
                        </a>
                    </div>
                </div>

                {{-- COLUNA DIREITA: FORMULÁRIO DE EDIÇÃO --}}
                <div class="col-md-7">
                    <div class="border-bottom border-warning pb-2 mb-3">
                        <h5 class="text-warning mb-0">
                            <i class="bi bi-sliders2"></i> ALTERAR NEGOCIAÇÃO
                        </h5>
                    </div>
                    <form action="{{ route('interests.update', $interest->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-warning small fw-bold">DATA DE RETIRADA</label>
                                <input type="date" name="data_retirada" 
                                       class="form-control bg-black text-white border-secondary" 
                                       value="{{ old('data_retirada', $interest->data_retirada ? date('Y-m-d', strtotime($interest->data_retirada)) : '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-warning small fw-bold">DATA DE DEVOLUÇÃO</label>
                                <input type="date" name="data_devolucao" 
                                       class="form-control bg-black text-white border-secondary" 
                                       value="{{ old('data_devolucao', $interest->data_devolucao ? date('Y-m-d', strtotime($interest->data_devolucao)) : '') }}">
                            </div>

                            @if(auth()->user()->is_admin)
                            <div class="col-md-12">
                                <label class="form-label text-warning small fw-bold">STATUS</label>
                                <select name="status" class="form-select bg-black text-white border-secondary">
                                    <option value="pendente" {{ $interest->status == 'pendente' ? 'selected' : '' }}>⚡ Pendente</option>
                                    <option value="alugado" {{ $interest->status == 'alugado' ? 'selected' : '' }}>🔁 Alugado</option>
                                    <option value="devolvido" {{ $interest->status == 'devolvido' ? 'selected' : '' }}>✅ Devolvido</option>
                                    <option value="cancelado" {{ $interest->status == 'cancelado' ? 'selected' : '' }}>❌ Cancelado</option>
                                </select>
                            </div>
                            @endif
                        </div>

                        <div class="mt-4 pt-3 border-top border-secondary d-flex gap-3 justify-content-end">
                            <a href="{{ route('interests.show', $interest->id) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> CANCELAR
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-check-circle"></i> SALVAR ALTERAÇÕES
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-outline-rock { 
    background: transparent; 
    border: 2px solid #ffc107; 
    color: #ffc107; 
    padding: 6px 20px; 
    text-decoration: none; 
    border-radius: 40px; 
    transition: 0.2s;
}
.btn-outline-rock:hover { 
    background: #ffc107; 
    color: black; 
}
.price-tag {
    font-family: 'JetBrains Mono', monospace;
    letter-spacing: -0.5px;
}
.text-dim {
    color: #adb5bd;
}
.btn-outline-info {
    border-color: #0dcaf0;
    color: #0dcaf0;
}
.btn-outline-info:hover {
    background: #0dcaf0;
    color: black;
}
</style>
@endsection