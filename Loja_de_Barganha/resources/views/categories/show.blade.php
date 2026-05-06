@extends('layouts.app')

@section('title', $category->nome . ' - Seção Underground')

@section('content')
<div class="container-fluid px-md-4 pb-5">
    {{-- BANNER HERO MINI (padrão do sistema) --}}
    <div class="hero-mini-grunge mb-5" style="background-image: url('{{ asset('images/category-bg.jpg') }}'); background-position: center 40%;">
        <div class="hero-mini-overlay"></div>
        <div class="hero-mini-content">
            <i class="bi {{ $category->icone ?? 'bi-tag-fill' }} fs-1 text-warning rock-flicker"></i>
            <h3 class="text-uppercase fw-bold mb-1">{{ $category->nome }}</h3>
            <p class="small text-dim m-0">{{ $category->tipo_midia }} • {{ $category->items->count() }} relíquias</p>
        </div>
    </div>

    {{-- CABEÇALHO COM DESCRIÇÃO E AÇÕES --}}
    <div class="d-flex flex-wrap justify-content-between align-items-start mb-5 pb-2 border-bottom border-warning">
        <div class="mb-3 mb-md-0">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div class="blink-caos"></div>
                <span class="badge bg-warning text-dark rounded-0 px-3 py-2 text-uppercase fw-bold">{{ $category->tipo_midia }}</span>
            </div>
            <p class="text-dim lead mb-2">{{ $category->descricao }}</p>
            <div class="d-flex gap-3 small text-muted">
                <span><i class="bi bi-people-fill text-warning me-1"></i> Público-alvo: {{ $category->publico_alvo }}</span>
                <span><i class="bi bi-box-seam-fill text-warning me-1"></i> Total: {{ $category->items->count() }} itens</span>
            </div>
        </div>
    </div>

    {{-- GRÁFICO DE FORMATOS COM CHART.JS --}}
    @if(!empty($labels) && !empty($data))
        <div class="card-grunge-filter p-4 mb-5">
            <div class="d-flex align-items-center gap-3 mb-3">
                <i class="bi bi-bar-chart-fill text-warning fs-3"></i>
                <h4 class="text-uppercase fw-bold text-warning m-0 rock-flicker">Formatos disponíveis no porão</h4>
                <div class="flex-grow-1"></div>
                <span class="badge bg-dark border-warning text-warning rounded-0 px-3 py-2">
                    {{ $category->items->count() }} relíquias
                </span>
            </div>
            <div style="max-width: 100%;">
                <canvas id="mediaChart" style="max-height: 300px;"></canvas>
            </div>
            <p class="text-dim small text-center mt-3 mb-0">
                <i class="bi bi-info-circle"></i> Distribuição dos formatos físicos dentro de <strong>{{ $category->nome }}</strong>
            </p>
        </div>

        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('mediaChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($labels),
                        datasets: [{
                            label: 'Quantidade de itens',
                            data: @json($data),
                            backgroundColor: '#e6b800',
                            borderColor: '#c49f47',
                            borderWidth: 1,
                            borderRadius: 4,
                            barPercentage: 0.7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                labels: { color: '#ccc', font: { family: 'monospace' } }
                            },
                            tooltip: { backgroundColor: '#111', titleColor: '#e6b800', bodyColor: '#ccc' }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: '#2a2a2a' },
                                ticks: { color: '#ccc', stepSize: 1 }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { color: '#e6b800', font: { weight: 'bold' } }
                            }
                        }
                    }
                });
            });
        </script>
        @endpush
    @endif

    {{-- BARRA DE BUSCA PARA ITENS DA CATEGORIA (opcional, via GET) --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card-grunge-filter p-2">
                <form action="{{ route('categories.show', $category->id) }}" method="GET" class="d-flex gap-2">
                    <div class="input-group flex-grow-1">
                        <span class="input-group-text bg-black border-secondary text-warning rounded-0">
                            <i class="bi bi-terminal-fill"></i>
                        </span>
                        <input type="text" name="search" class="form-control bg-black text-white border-secondary rounded-0 shadow-none"
                               placeholder=">_ buscar item nesta seção..." value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="btn btn-outline-dirty">CAÇAR</button>
                    @if(request('search'))
                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-outline-secondary">✕ LIMPAR</a>
                    @endif
                </form>
            </div>
        </div>
        <div class="col-md-6 text-md-end">
            <p class="text-dim small text-uppercase mt-2 mb-0">
                <i class="bi bi-record-fill text-warning me-1"></i>
                {{ $items->total() ?? $category->items->count() }} relíquias no porão
            </p>
        </div>
    </div>

    {{-- GRID DE ITENS (cards no estilo vitrine) --}}
    <div class="vitrine-grid">
        @forelse(($items ?? $category->items) as $item)
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
                        <span class="item-category">{{ $category->nome }}</span>
                        <h5>{{ Str::limit($item->titulo, 35) }}</h5>
                        <p>{{ $item->artista_diretor ?? $item->empresa_produtora }}</p>
                        <div class="item-meta">
                            <span><i class="bi bi-disc-fill"></i> {{ $item->mediaFormat->nome ?? 'Formato' }}</span>
                            @if($item->condition)
                                <span><i class="bi bi-shield-check"></i> {{ $item->condition->estado_midia }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <a href="{{ route('items.show', $item->id) }}" class="item-link"></a>
            </div>
        @empty
            <div class="empty-garimpo">
                <i class="bi bi-emoji-frown-fill"></i>
                <h3>VAZIO NO PORÃO</h3>
                <p>Nenhum item cadastrado nesta seção ainda.</p>
                @if(auth()->check() && auth()->user()->is_admin)
                    <a href="{{ route('items.create', ['category_id' => $category->id]) }}" class="btn btn-blood btn-sm mt-2">CADASTRAR PRIMEIRA RELÍQUIA</a>
                @endif
            </div>
        @endforelse
    </div>

    {{-- PAGINAÇÃO (caso o controller envie $items paginado) --}}
    @if(isset($items) && method_exists($items, 'links'))
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

{{-- ESTILOS ESPECÍFICOS (complementares aos globais) --}}
@push('styles')
<style>
    /* Garantia dos estilos de vitrine (caso não estejam no global) */
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
        margin: 0 0 6px;
    }
    .item-meta {
        display: flex;
        gap: 12px;
        font-size: 0.65rem;
        color: #666;
        margin-top: 6px;
    }
    .item-meta i {
        margin-right: 3px;
        font-size: 0.7rem;
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
    .pagination-custom .pagination {
        --bs-pagination-bg: #111;
        --bs-pagination-color: var(--dirty-gold);
        --bs-pagination-active-bg: var(--dirty-gold);
        --bs-pagination-active-border-color: var(--dirty-gold);
        --bs-pagination-hover-bg: var(--rust-red);
        --bs-pagination-hover-color: white;
    }
    .btn-outline-warrior {
        background: transparent;
        border: 2px solid var(--dirty-gold);
        color: var(--dirty-gold);
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 0;
    }
    .btn-outline-warrior:hover {
        background: var(--dirty-gold);
        color: black;
    }
    .btn-blood {
        background: var(--rust-red);
        border: none;
        color: white;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 0;
    }
    .btn-blood:hover {
        background: var(--dirty-gold);
        color: black;
    }
    .card-grunge-filter {
        background: #11100e;
        border: 1px solid #2a2520;
    }
    .hero-mini-grunge {
        position: relative;
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
    @media (max-width: 768px) {
        .hero-mini-content { width: 95%; padding: 1rem; }
        .vitrine-grid { gap: 15px; }
        .item-meta { flex-direction: column; gap: 4px; }
    }
</style>
@endpush
@endsection