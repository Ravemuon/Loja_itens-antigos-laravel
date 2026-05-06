@extends('layouts.app')

@section('content')
@php
    $isAdmin = auth()->check() && auth()->user()->is_admin;
    $mode = request()->get('mode', $isAdmin ? 'stock' : 'storefront');
@endphp

<div class="container-fluid px-md-4 pb-5">
        {{-- 🎸 BANNER HERO MINI – resolvendo o "colado no nav" --}}
    <div class="hero-mini-grunge mb-5">
        <div class="hero-mini-overlay"></div>
        <div class="hero-mini-content">
            @if($isAdmin && $mode === 'stock')
                <i class="bi bi-database-gear fs-1 text-warning"></i>
                <h3 class="text-uppercase fw-bold mb-1">PAINEL DE CONTROLE</h3>
                <p class="small text-dim m-0">Gerencie o caos com segurança</p>
            @else
                <i class="bi bi-lightning-charge-fill fs-1 text-warning rock-flicker"></i>
                <h3 class="text-uppercase fw-bold mb-1">VITRINE DO CAOS</h3>
                <p class="small text-dim m-0">Garimpe relíquias underground</p>
            @endif
        </div>
    </div>
    

    {{-- HEADER COM TOGGLE PARA ADMIN --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom border-warning">
        <div>
            <div class="d-flex align-items-center gap-2">
                <div class="blink-caos"></div>
                <h2 class="fw-bold text-uppercase m-0" style="font-family: 'Special Elite', cursive; letter-spacing: 3px;">
                    <i class="bi bi-box-seam-fill text-warning me-2"></i>
                    @if($isAdmin && $mode === 'stock')
                        ARQUIVO <span class="text-warning">UNDERGROUND</span>
                    @else
                        VITRINE <span class="text-warning">DO CAOS</span>
                    @endif
                </h2>
            </div>
            <p class="text-dim mb-0 small text-uppercase tracking-widest mt-1">
                ⚡ {{ $items->total() }} relíquias no sistema ⚡
            </p>
        </div>

        <div class="d-flex gap-2 mt-3 mt-sm-0">
            @if($isAdmin)
                <div class="btn-group" role="group">
                    <a href="{{ route('items.index', array_merge(request()->query(), ['mode' => 'stock'])) }}"
                       class="btn {{ $mode === 'stock' ? 'btn-blood' : 'btn-outline-warrior' }}">
                        <i class="bi bi-table me-1"></i> MODO ESTOQUE
                    </a>
                    <a href="{{ route('items.index', array_merge(request()->query(), ['mode' => 'storefront'])) }}"
                       class="btn {{ $mode === 'storefront' ? 'btn-blood' : 'btn-outline-warrior' }}">
                        <i class="bi bi-grid-3x3-gap-fill me-1"></i> MODO VITRINE
                    </a>
                </div>

                @if($mode === 'stock')
                    {{-- 🔥 BOTÃO DO RELATÓRIO PDF (com filtros atuais) --}}
                    <a href="{{ route('relatorio.itens', request()->query()) }}" 
                       class="btn btn-outline-warrior" 
                       target="_blank"
                       title="Gerar relatório PDF com os filtros atuais">
                        <i class="bi bi-file-pdf-fill me-1"></i> RELATÓRIO PDF
                    </a>

                    <a href="{{ route('categories.index') }}" class="btn btn-outline-warrior">
                        <i class="bi bi-tags-fill me-1"></i> GERENCIAR SEÇÕES
                    </a>
                @endif

                <a href="{{ route('items.create') }}" class="btn btn-blood">
                    <i class="bi bi-plus-lg me-1"></i> NOVA RELÍQUIA
                </a>
            @endif
        </div>
    </div>

    {{-- FILTROS E BUSCA (comuns aos dois modos) --}}
    <div class="row g-3 mb-4">
        <div class="col-md-7">
            <div class="card-grunge-filter p-2">
                <form action="{{ route('items.index') }}" method="GET" class="d-flex gap-2">
                    @foreach(request()->except(['search', 'page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <div class="input-group flex-grow-1">
                        <span class="input-group-text bg-black border-secondary text-warning rounded-0">
                            <i class="bi bi-terminal-fill"></i>
                        </span>
                        <input type="text" name="search" class="form-control bg-black text-white border-secondary rounded-0 shadow-none"
                               placeholder=">_ rastrear por título, artista, estúdio ou gênero..." value="{{ $search ?? '' }}">
                    </div>
                    <button type="submit" class="btn btn-outline-dirty">CAÇAR</button>
                </form>
            </div>
        </div>
        <div class="col-md-5">
            <div class="d-flex gap-2 h-100 align-items-center justify-content-md-end">
                <span class="text-dim small text-uppercase me-1">filtro rápido:</span>
                <div class="btn-group" role="group">
                    @php $currentMidia = request('tipo_midia'); @endphp
                    <a href="{{ route('items.index', array_merge(request()->except('tipo_midia'), ['tipo_midia' => 'Música'])) }}"
                       class="btn btn-midia-filter {{ $currentMidia == 'Música' ? 'active' : '' }}">🎵 Música</a>
                    <a href="{{ route('items.index', array_merge(request()->except('tipo_midia'), ['tipo_midia' => 'Jogo'])) }}"
                       class="btn btn-midia-filter {{ $currentMidia == 'Jogo' ? 'active' : '' }}">🎮 Jogos</a>
                    <a href="{{ route('items.index', array_merge(request()->except('tipo_midia'), ['tipo_midia' => 'Filme'])) }}"
                       class="btn btn-midia-filter {{ $currentMidia == 'Filme' ? 'active' : '' }}">🎬 Filmes</a>
                    @if($currentMidia)
                        <a href="{{ route('items.index', request()->except('tipo_midia')) }}" class="btn btn-outline-secondary">✕ Limpar</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- MODO ESTOQUE (TABELA ADMINISTRATIVA) --}}
    @if($isAdmin && $mode === 'stock')
        <div class="card-grunge-table shadow-lg overflow-hidden">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead class="grunge-thead">
                        <tr>
                            <th class="ps-4" style="width: 80px;">🖼️ CAPA</th>
                            <th>🎸 ITEM / PRODUTOR</th>
                            <th>🏷️ SEÇÃO</th>
                            <th>💿 MÍDIA</th>
                            <th class="text-end">💰 PREÇO SUJO</th>
                            <th class="text-center" style="width: 140px;">🔧 AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr class="item-row">
                                <td class="ps-4">
                                    @if($item->capa)
                                        <img src="{{ asset('storage/' . $item->capa) }}" class="grunge-thumb" style="width: 55px; height: 55px; object-fit: cover;">
                                    @else
                                        <div class="grunge-thumb-placeholder">
                                            <i class="bi bi-question-octagon-fill"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-white">{{ $item->titulo }}</div>
                                    <div class="small text-dirty text-uppercase">{{ $item->artista_diretor ?? $item->empresa_produtora }}</div>
                                    @if($item->ano)
                                        <div class="small text-muted">{{ $item->ano }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="category-badge">{{ $item->category->nome }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @php
                                            $midiaIcon = match($item->tipo_midia) {
                                                'Filme' => 'bi-film',
                                                'Jogo' => 'bi-controller',
                                                default => 'bi-disc-fill'
                                            };
                                        @endphp
                                        <i class="bi {{ $midiaIcon }} fs-5 text-dirty"></i>
                                        <div>
                                            <span class="d-block fw-semibold">{{ $item->tipo_midia }}</span>
                                            <span class="text-muted small">{{ $item->mediaFormat->nome ?? '---' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="price-grunge">R$ {{ number_format($item->preco, 2, ',', '.') }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-row gap-1 justify-content-center">
                                        <a href="{{ route('items.show', $item->id) }}" class="btn btn-sm btn-dark border-secondary action-icon" title="Ver detalhes">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        @if($isAdmin)
                                            <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-dark border-secondary action-icon" title="Editar">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('❌ EXCLUIR PERMANENTEMENTE? Essa ação não pode ser desfeita.')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-dark border-secondary action-icon" title="Excluir">
                                                    <i class="bi bi-trash3-fill text-danger"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-archive fs-1 d-block mb-3 opacity-25"></i>
                                    <h5 class="fw-bold text-uppercase">Nenhum artefato encontrado</h5>
                                    <p class="small">O rastro sumiu. Tente outro termo ou cadastre algo novo.</p>
                                    <a href="{{ route('items.create') }}" class="btn btn-blood btn-sm">CADASTRAR PRIMEIRA RELÍQUIA</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginação modo estoque --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
            <div class="small text-muted">
                <i class="bi bi-record-fill text-warning me-1"></i> Mostrando {{ $items->firstItem() ?? 0 }} a {{ $items->lastItem() ?? 0 }} de {{ $items->total() }} relíquias
            </div>
            <div class="pagination-grunge">
                {{ $items->appends(request()->query())->links() }}
            </div>
        </div>

    {{-- MODO VITRINE (CARDS) --}}
    @else
        <div class="vitrine-grid">
            @forelse($items as $item)
                <div class="item-card">
                    <div class="item-card-inner">
                        <div class="item-image">
                            @if($item->capa)
                                <img src="{{ asset('storage/' . $item->capa) }}" alt="{{ $item->titulo }}">
                            @else
                                <div class="item-no-image">
                                    <i class="bi bi-disc-fill"></i>
                                </div>
                            @endif
                            <div class="item-price">R$ {{ number_format($item->preco, 2, ',', '.') }}</div>
                            <div class="item-overlay">
                                <span>VER RELÍQUIA →</span>
                            </div>
                        </div>
                        <div class="item-info">
                            <span class="item-category">{{ $item->category->nome }}</span>
                            <h5>{{ Str::limit($item->titulo, 35) }}</h5>
                            <p>{{ $item->artista_diretor ?? $item->empresa_produtora }}</p>
                        </div>
                    </div>
                    <a href="{{ route('items.show', $item->id) }}" class="item-link"></a>
                </div>
            @empty
                <div class="empty-garimpo">
                    <i class="bi bi-emoji-frown-fill"></i>
                    <h3>NADA ENCONTRADO!</h3>
                    <p>Tente outros filtros ou palavras-chave.</p>
                    @if($isAdmin)
                        <a href="{{ route('items.create') }}" class="btn btn-blood btn-sm mt-2">CADASTRAR PRIMEIRA RELÍQUIA</a>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- Paginação modo vitrine --}}
        <div class="pagination-custom mt-5">
            {{ $items->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif

    {{-- DIVISÓRIA INFERIOR --}}
    <div class="divider-grunge divider-3 mt-5" style="min-height: 80px; margin-bottom: 0;">
        <div class="divider-content py-2">
            <i class="bi bi-skull me-2"></i> ARQUIVO MORTO — EDIÇÃO 2026 <i class="bi bi-skull ms-2"></i>
        </div>
    </div>
</div>

{{-- ESTILOS (compartilhados pelos dois modos + banner hero-mini) --}}
@push('styles')
<style>
    /* blink do caos */
    .blink-caos {
        width: 14px;
        height: 14px;
        background: var(--dirty-gold);
        border-radius: 0px;
        animation: blink 1.2s infinite;
        box-shadow: 0 0 5px var(--rust-red);
    }

    /* BANNER HERO MINI - resolve o espaço colado no nav */
    .hero-mini-grunge {
        position: relative;
        background-image: url('https://images.unsplash.com/photo-1498038432885-c6f3f1b912ee?q=80&w=2070&auto=format'); /* guitar close-up */
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
    @media (max-width: 768px) {
        .hero-mini-content { width: 95%; padding: 1rem; }
        .hero-mini-content h3 { font-size: 1.1rem; }
    }

    /* botões personalizados */
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
        box-shadow: 0 4px 12px rgba(180,43,43,0.4);
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

    /* Estilos modo tabela */
    .card-grunge-table {
        background: #0c0b0a;
        border: 1px solid #2a2522;
        transition: 0.1s;
    }
    .grunge-thead tr th {
        background: #0a0a0a;
        color: var(--dirty-gold);
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.75rem;
        padding: 14px 8px;
        border-bottom: 2px solid var(--rust-red);
    }
    .item-row {
        border-left: 3px solid transparent;
        transition: 0.1s;
    }
    .item-row:hover {
        background-color: rgba(212, 160, 23, 0.08);
        border-left-color: var(--dirty-gold);
    }
    .grunge-thumb {
        filter: grayscale(0.3);
        transition: 0.2s;
        border: 1px solid #3a3a3a;
    }
    .item-row:hover .grunge-thumb {
        filter: grayscale(0);
        transform: scale(1.05);
    }
    .grunge-thumb-placeholder {
        width: 55px;
        height: 55px;
        background: #111;
        border: 1px dashed #555;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #777;
    }
    .category-badge {
        background: #1e1a16;
        border-left: 4px solid var(--dirty-gold);
        padding: 4px 12px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--dirty-gold);
    }
    .price-grunge {
        font-family: 'Courier New', monospace;
        font-weight: 900;
        font-size: 1.1rem;
        color: var(--dirty-gold);
        background: #00000066;
        padding: 2px 8px;
        letter-spacing: -0.5px;
    }
    .action-icon {
        width: 32px;
        transition: 0.1s;
    }
    .action-icon:hover {
        background: var(--dirty-gold) !important;
        color: black !important;
        border-color: var(--dirty-gold) !important;
    }
    .action-icon:hover i {
        color: black !important;
    }

    /* Estilos modo vitrine (cards) */
    .vitrine-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }
    .item-card {
        position: relative;
        background: #111;
        border: 1px solid #2a2a2a;
        transition: 0.2s;
    }
    .item-card:hover {
        border-color: var(--dirty-gold);
        transform: translateY(-5px);
    }
    .item-image {
        height: 220px;
        overflow: hidden;
        position: relative;
    }
    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.3s;
    }
    .item-card:hover .item-image img {
        transform: scale(1.05);
    }
    .item-price {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--dirty-gold);
        color: black;
        padding: 5px 12px;
        font-weight: bold;
        font-size: 0.8rem;
        transform: rotate(3deg);
        z-index: 2;
    }
    .item-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: 0.2s;
    }
    .item-card:hover .item-overlay {
        opacity: 1;
    }
    .item-overlay span {
        color: var(--dirty-gold);
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    .item-info {
        padding: 15px;
    }
    .item-category {
        font-size: 0.65rem;
        background: var(--rust-red);
        padding: 2px 8px;
        display: inline-block;
        margin-bottom: 8px;
    }
    .item-info h5 {
        font-size: 0.9rem;
        font-weight: 900;
        text-transform: uppercase;
        color: var(--dirty-gold);
        margin: 0 0 5px;
    }
    .item-info p {
        font-size: 0.75rem;
        color: #888;
        margin: 0;
    }
    .item-link {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }
    .empty-garimpo {
        text-align: center;
        padding: 60px;
        background: #0a0a0a;
        border: 2px dashed #2a2a2a;
        grid-column: 1 / -1;
    }
    .empty-garimpo i {
        font-size: 3rem;
        color: #666;
    }
    .empty-garimpo h3 {
        margin-top: 15px;
        font-size: 1.2rem;
    }

    /* paginação */
    .pagination-grunge .pagination {
        --bs-pagination-bg: #14100e;
        --bs-pagination-color: var(--dirty-gold);
        --bs-pagination-border-color: #3a2e28;
        --bs-pagination-hover-bg: var(--dirty-gold);
        --bs-pagination-hover-color: #000;
        --bs-pagination-active-bg: var(--rust-red);
        --bs-pagination-active-border-color: var(--rust-red);
        --bs-pagination-disabled-bg: #0f0c0a;
        gap: 5px;
    }
    .pagination-grunge .page-link {
        border-radius: 0px !important;
        font-weight: bold;
        text-transform: uppercase;
    }
    .pagination-custom .pagination {
        --bs-pagination-bg: #111;
        --bs-pagination-color: var(--dirty-gold);
        --bs-pagination-active-bg: var(--dirty-gold);
        --bs-pagination-active-border-color: var(--dirty-gold);
        --bs-pagination-hover-bg: var(--rust-red);
        --bs-pagination-hover-color: white;
    }

    /* filtro card */
    .card-grunge-filter {
        background: #11100e;
        border: 1px solid #2a2520;
    }
</style>
@endpush

@push('scripts')
<script>
    document.querySelectorAll('.btn-midia-filter').forEach(btn => {
        btn.addEventListener('click', (e) => {
            let url = btn.getAttribute('href');
            if(url && !url.includes('search=') && '{{ $search ?? '' }}') {
                url += (url.includes('?') ? '&' : '?') + 'search={{ urlencode($search) }}';
                btn.setAttribute('href', url);
            }
        });
    });

    document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
        form.addEventListener('submit', (e) => {
            if(!confirm('⚠️ EXCLUSÃO PERMANENTE! Essa relíquia desaparecerá do estoque. Continuar?')) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
@endsection