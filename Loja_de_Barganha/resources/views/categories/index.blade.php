@extends('layouts.app')

@section('content')
<div class="container pb-5">
    {{-- 🎸 BANNER HERO MINI --}}
    <div class="hero-mini-grunge mb-5">
        <div class="hero-mini-overlay"></div>
        <div class="hero-mini-content">
            <i class="bi bi-tags-fill fs-1 text-warning rock-flicker"></i>
            <h3 class="text-uppercase fw-bold mb-1">CATEGORIAS DO CAOS</h3>
            <p class="small text-dim m-0">Explore seções podres e garimpe relíquias únicas</p>
        </div>
    </div>

    {{-- Cabeçalho com botão nova categoria (simplificado) --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom border-warning">
        <div>
            <div class="d-flex align-items-center gap-2">
                <div class="vitrine-blink"></div>
                <h2 class="fw-bold text-uppercase m-0" style="font-family: 'Special Elite', cursive; letter-spacing: 3px;">
                    <i class="bi bi-collection-fill text-warning me-2"></i>
                    SEÇÕES <span class="text-warning">UNDERGROUND</span>
                </h2>
            </div>
            <p class="text-dim mb-0 small text-uppercase tracking-widest mt-1">
                ⚡ {{ $categories->total() }} seções no sistema ⚡
            </p>
        </div>

        @auth
            <div class="mt-3 mt-sm-0">
                <a href="{{ route('categories.create') }}" class="btn btn-blood">
                    <i class="bi bi-plus-lg me-1"></i> NOVA CATEGORIA
                </a>
            </div>
        @endauth
    </div>

    {{-- Filtros de tipo de mídia e busca --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="btn-group shadow" role="group">
                <a href="{{ route('categories.index', array_merge(request()->except('tipo_midia'), ['tipo_midia' => 'Música'])) }}" 
                   class="btn btn-midia-filter {{ request('tipo_midia') == 'Música' ? 'active' : '' }}">🎵 Música</a>
                <a href="{{ route('categories.index', array_merge(request()->except('tipo_midia'), ['tipo_midia' => 'Jogo'])) }}" 
                   class="btn btn-midia-filter {{ request('tipo_midia') == 'Jogo' ? 'active' : '' }}">🎮 Jogos</a>
                <a href="{{ route('categories.index', array_merge(request()->except('tipo_midia'), ['tipo_midia' => 'Filme'])) }}" 
                   class="btn btn-midia-filter {{ request('tipo_midia') == 'Filme' ? 'active' : '' }}">🎬 Filmes</a>
                @if(request('tipo_midia'))
                    <a href="{{ route('categories.index', request()->except('tipo_midia')) }}" class="btn btn-outline-secondary">✕ Limpar</a>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-grunge-filter p-2">
                <form action="{{ route('categories.index') }}" method="GET" class="d-flex gap-2">
                    @foreach(request()->except(['search', 'page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <div class="input-group flex-grow-1">
                        <span class="input-group-text bg-black border-secondary text-warning rounded-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control bg-black text-white border-secondary rounded-0 shadow-none"
                               placeholder=">_ filtrar por nome da seção..." value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="btn btn-outline-dirty">RASTREAR</button>
                    @if(request('search'))
                        <a href="{{ route('categories.index', request()->except('search')) }}" class="btn btn-outline-secondary">✕ LIMPAR</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    {{-- Grid de Categorias --}}
    <div class="row g-4">
        @forelse($categories as $category)
            <div class="col-md-4 col-lg-3">
                <div class="card-grunge h-100 p-4 position-relative border-secondary">
                    
                    {{-- Botões de edição/exclusão para admin --}}
                    @auth
                        <div class="position-absolute top-0 end-0 p-2 d-flex gap-1" style="z-index: 20;">
                            <a href="{{ route('categories.edit', $category->id) }}" 
                               class="btn btn-sm btn-dark border-secondary text-white" 
                               title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('❌ EXCLUIR PERMANENTEMENTE? Os itens dessa seção também serão removidos.')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-dark border-danger text-danger" title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endauth

                    <a href="{{ route('categories.show', $category->id) }}" class="text-decoration-none text-center d-flex flex-column h-100">
                        <div class="category-icon mb-3">
                            @php
                                $slug = Str::lower($category->nome);
                                $icon = 'bi-bookmark-star';
                                $color = 'text-dirty';
                                
                                if(Str::contains($slug, ['rock', 'metal', 'musica', 'disco', 'vinil'])) { $icon = 'bi-vinyl-fill'; $color = 'text-rust'; }
                                elseif(Str::contains($slug, ['filme', 'cinema', 'vhs', 'terror'])) { $icon = 'bi-film'; $color = 'text-warning'; }
                                elseif(Str::contains($slug, ['jogo', 'game', 'nintendo', 'retro'])) { $icon = 'bi-controller'; $color = 'text-info'; }
                            @endphp
                            <i class="bi {{ $icon }} {{ $color }} display-4 rock-flicker" style="filter: drop-shadow(3px 3px 0px #000);"></i>
                        </div>
                        
                        <h3 class="text-white fw-bold text-uppercase mb-2" style="font-family: 'Oswald', sans-serif; letter-spacing: 1px;">
                            {{ $category->nome }}
                        </h3>
                        
                        <div class="mt-auto pt-3">
                            <span class="badge bg-warning text-dark fw-bold text-uppercase px-3 py-2 rounded-0">
                                {{ $category->items_count }} 🧨 ITENS
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-garimpo text-center py-5">
                    <i class="bi bi-emoji-frown-fill fs-1 d-block mb-3 opacity-50"></i>
                    <h3 class="text-uppercase">NENHUMA SEÇÃO ENCONTRADA</h3>
                    <p class="text-dim">Tente outros filtros ou cadastre uma nova categoria.</p>
                    @auth
                        <a href="{{ route('categories.create') }}" class="btn btn-blood mt-2">CRIAR PRIMEIRA SEÇÃO</a>
                    @endauth
                </div>
            </div>
        @endforelse
    </div>

    {{-- Paginação --}}
    <div class="pagination-custom mt-5">
        {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

    {{-- Divisória --}}
    <div class="divider-grunge divider-2 mt-5" style="min-height: 100px; margin-bottom: 0;">
        <div class="divider-content py-3">
            <i class="bi bi-record-fill me-2 text-rust"></i>
            MAIS CATEGORIAS EM BREVE
            <i class="bi bi-record-fill ms-2 text-rust"></i>
        </div>
    </div>
</div>

{{-- Estilos (mantidos os mesmos, apenas removi os não utilizados) --}}
@push('styles')
<style>
    .vitrine-blink {
        width: 16px;
        height: 16px;
        background: var(--rust-red);
        border-radius: 0;
        animation: blink 1s infinite;
        box-shadow: 0 0 6px var(--dirty-gold);
    }
    .category-icon { 
        transition: transform 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1); 
    }
    .card-grunge:hover .category-icon { 
        transform: scale(1.15) rotate(-4deg); 
    }
    .card-grunge {
        background: #1c1814e0;
        backdrop-filter: blur(2px);
        transition: all 0.2s ease;
    }
    .card-grunge:hover {
        transform: translateY(-6px);
        border-color: var(--dirty-gold);
        box-shadow: 10px 10px 0px rgba(0,0,0,0.6);
    }
    .badge.bg-warning {
        background-color: var(--dirty-gold) !important;
        font-weight: 800;
        letter-spacing: 1px;
    }
    .btn-midia-filter {
        background: #1a1a1a;
        border: 1px solid #3a3a3a;
        color: #ccc;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        padding: 5px 12px;
        transition: 0.1s;
        border-radius: 0;
    }
    .btn-midia-filter.active {
        background: var(--dirty-gold);
        color: black;
        border-color: var(--dirty-gold);
    }
    .btn-midia-filter:hover:not(.active) {
        background: #2a2a2a;
        color: var(--dirty-gold);
    }
    .btn-outline-dirty {
        background: transparent;
        border: 2px solid var(--dirty-gold);
        color: var(--dirty-gold);
        font-weight: 800;
        border-radius: 0;
        text-transform: uppercase;
        transition: 0.1s;
    }
    .btn-outline-dirty:hover {
        background: var(--dirty-gold);
        color: black;
    }
    .card-grunge-filter {
        background: #11100e;
        border: 1px solid #2a2520;
    }
    .empty-garimpo {
        background: #0a0a0a;
        border: 2px dashed #2a2a2a;
    }
    .hero-mini-grunge {
        position: relative;
        background-image: url('https://images.unsplash.com/photo-1498038432885-c6f3f1b912ee?q=80&w=2070&auto=format');
        background-size: cover;
        background-position: center 30%;
        min-height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        border-left: 6px solid var(--dirty-gold);
        border-right: 6px solid var(--rust-red);
        box-shadow: 0 8px 20px rgba(0,0,0,0.6);
        margin-bottom: 2rem;
    }
    .hero-mini-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.65);
        backdrop-filter: blur(2px);
    }
    .hero-mini-content {
        position: relative;
        z-index: 2;
        padding: 1.8rem;
        background: rgba(10, 8, 6, 0.7);
        border-top: 2px solid var(--dirty-gold);
        border-bottom: 2px solid var(--dirty-gold);
        width: 80%;
    }
    .hero-mini-content i {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }
    .hero-mini-content h3 {
        font-family: 'Special Elite', cursive;
        letter-spacing: 3px;
        font-size: 1.4rem;
        text-shadow: 2px 2px 0 #1a1a1a;
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
        box-shadow: 0 4px 12px rgba(180,43,43,0.4);
    }
    @media (max-width: 768px) {
        .hero-mini-content { width: 95%; padding: 1rem; }
        .hero-mini-content h3 { font-size: 1.1rem; }
        .vitrine-blink { display: none; }
        .position-absolute { position: static !important; text-align: right; margin-bottom: 8px; }
    }
    .pagination-custom .pagination {
        --bs-pagination-bg: #111;
        --bs-pagination-color: var(--dirty-gold);
        --bs-pagination-active-bg: var(--dirty-gold);
        --bs-pagination-active-border-color: var(--dirty-gold);
        --bs-pagination-hover-bg: var(--rust-red);
        --bs-pagination-hover-color: white;
    }
</style>
@endpush
@endsection