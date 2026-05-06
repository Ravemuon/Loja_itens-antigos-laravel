@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Cabeçalho da página --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center gap-3">
                <div class="blink-caos"></div>
                <h1 class="fw-bold text-uppercase m-0" style="font-family: 'Special Elite', cursive; letter-spacing: 3px;">
                    <i class="bi bi-plus-circle-fill text-warning me-2"></i>
                    NOVA <span class="text-warning">CATEGORIA</span>
                </h1>
            </div>
            <p class="text-dim mt-2">Registre uma nova seção podre no estoque underground.</p>
        </div>
    </div>

    {{-- Formulário --}}
    <div class="card-grunge p-4">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="row g-4">
                {{-- Nome --}}
                <div class="col-md-6">
                    <label for="nome" class="form-label text-warning fw-bold text-uppercase small">Nome da Categoria <span class="text-danger">*</span></label>
                    <input type="text" name="nome" id="nome" 
                           class="form-control bg-black text-white border-secondary rounded-0 @error('nome') is-invalid @enderror"
                           value="{{ old('nome') }}" required>
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tipo de Mídia --}}
                <div class="col-md-6">
                    <label for="tipo_midia" class="form-label text-warning fw-bold text-uppercase small">Tipo de Mídia <span class="text-danger">*</span></label>
                    <select name="tipo_midia" id="tipo_midia" 
                            class="form-select bg-black text-white border-secondary rounded-0 @error('tipo_midia') is-invalid @enderror" required>
                        <option value="">Selecione...</option>
                        <option value="Música" {{ old('tipo_midia') == 'Música' ? 'selected' : '' }}>🎵 Música</option>
                        <option value="Jogo" {{ old('tipo_midia') == 'Jogo' ? 'selected' : '' }}>🎮 Jogo</option>
                        <option value="Filme" {{ old('tipo_midia') == 'Filme' ? 'selected' : '' }}>🎬 Filme</option>
                        <option value="Outro" {{ old('tipo_midia') == 'Outro' ? 'selected' : '' }}>⚡ Outro</option>
                    </select>
                    @error('tipo_midia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Descrição --}}
                <div class="col-12">
                    <label for="descricao" class="form-label text-warning fw-bold text-uppercase small">Descrição do Caos <span class="text-danger">*</span></label>
                    <textarea name="descricao" id="descricao" rows="4" 
                              class="form-control bg-black text-white border-secondary rounded-0 @error('descricao') is-invalid @enderror"
                              required>{{ old('descricao') }}</textarea>
                    @error('descricao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Público-alvo --}}
                <div class="col-md-6">
                    <label for="publico_alvo" class="form-label text-warning fw-bold text-uppercase small">Público-alvo <span class="text-danger">*</span></label>
                    <input type="text" name="publico_alvo" id="publico_alvo" 
                           class="form-control bg-black text-white border-secondary rounded-0 @error('publico_alvo') is-invalid @enderror"
                           value="{{ old('publico_alvo') }}" required placeholder="Ex: Headbangers, Colecionadores, Gamers...">
                    @error('publico_alvo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Ícone (opcional) --}}
                <div class="col-md-6">
                    <label for="icone" class="form-label text-warning fw-bold text-uppercase small">Ícone (classe Bootstrap Icons)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-warning rounded-0">
                            <i class="bi bi-grid"></i>
                        </span>
                        <input type="text" name="icone" id="icone" 
                               class="form-control bg-black text-white border-secondary rounded-0 @error('icone') is-invalid @enderror"
                               value="{{ old('icone', 'bi-bookmark-star') }}" placeholder="ex: bi-vinyl-fill">
                    </div>
                    <div class="form-text text-dim small">Deixe em branco para usar o padrão <code>bi-bookmark-star</code>. <a href="https://icons.getbootstrap.com/" target="_blank" class="text-warning">Ver ícones</a></div>
                    @error('icone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Botões --}}
                <div class="col-12 mt-4">
                    <div class="d-flex gap-3 justify-content-end">
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-warrior px-4">
                            <i class="bi bi-x-lg me-1"></i> CANCELAR
                        </a>
                        <button type="submit" class="btn-blood px-4">
                            <i class="bi bi-save2 me-1"></i> CRIAR CATEGORIA
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Divisória inferior --}}
    <div class="divider-grunge divider-1 mt-5" style="min-height: 80px;">
        <div class="divider-content py-2">
            <i class="bi bi-skull me-2"></i> NOVA SEÇÃO — CAOS REGISTRADO <i class="bi bi-skull ms-2"></i>
        </div>
    </div>
</div>

@push('styles')
<style>
    .blink-caos {
        width: 14px;
        height: 14px;
        background: var(--dirty-gold);
        animation: blink 1s infinite;
        box-shadow: 0 0 5px var(--rust-red);
    }
    .card-grunge {
        background: #1c1814e0;
        backdrop-filter: blur(2px);
        border: 1px solid #3a2e28;
        box-shadow: 8px 8px 0px rgba(0,0,0,0.5);
    }
    .btn-outline-warrior {
        background: transparent;
        border: 2px solid var(--dirty-gold);
        color: var(--dirty-gold);
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.2s;
        border-radius: 0;
    }
    .btn-outline-warrior:hover {
        background: var(--dirty-gold);
        color: black;
        transform: translateY(-2px);
    }
    .btn-blood {
        background: var(--rust-red);
        border: none;
        color: white;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 0;
        transition: 0.2s;
    }
    .btn-blood:hover {
        background: var(--dirty-gold);
        color: black;
        transform: translateY(-2px);
    }
</style>
@endpush
@endsection