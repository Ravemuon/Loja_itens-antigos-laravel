@extends('layouts.app')

@section('title', $item->titulo . ' - BARGANHA UNDERGROUND')

@section('content')
<div class="item-detail-bg">
    <div class="container py-4">
        {{-- Botão voltar estilizado --}}
        <div class="mb-4">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('items.index') }}" class="btn-rust-outline-sm">
                <i class="bi bi-arrow-left-short"></i> VOLTAR À VITRINE
            </a>
        </div>

        <div class="row g-4">
            {{-- COLUNA ESQUERDA: CAPA + FICHA TÉCNICA (estilo cassete) --}}
            <div class="col-lg-4">
                <div class="cassette-card h-100">
                    <div class="cassette-cover">
                        @if($item->capa)
                            <img src="{{ Storage::url($item->capa) }}" class="cassette-img" alt="{{ $item->titulo }}">
                        @else
                            <div class="cassette-no-img">
                                <i class="bi bi-vinyl-fill"></i>
                                <span>SEM CAPA</span>
                            </div>
                        @endif
                    </div>
                    <div class="cassette-body">
                        <div class="cassette-label">
                            <i class="bi bi-cassette-fill"></i> FICHA TÉCNICA
                        </div>
                        <ul class="tech-list">
                            <li><i class="bi bi-tag-fill"></i> <strong>Categoria:</strong> {{ $item->category->nome ?? '—' }}</li>
                            <li><i class="bi bi-disc-fill"></i> <strong>Formato:</strong> {{ $item->mediaFormat->nome ?? '—' }}</li>
                            <li><i class="bi bi-cash-stack"></i> <strong>Preço:</strong> <span class="price-highlight">R$ {{ number_format($item->preco, 2, ',', '.') }}</span></li>
                            <li><i class="bi bi-box-seam-fill"></i> <strong>Estoque:</strong> {{ $item->quantidade_estoque }} un.</li>
                        </ul>

                        @if($item->condition)
                            <div class="condition-box">
                                <div class="condition-title">⚙️ ESTADO DE CONSERVAÇÃO</div>
                                <div class="condition-item"><span>📦 Caixa:</span> {{ $item->condition->estado_caixa }}</div>
                                <div class="condition-item"><span>💿 Mídia:</span> {{ $item->condition->estado_midia }}</div>
                                <div class="condition-item"><span>📖 Manual:</span> {{ $item->condition->possui_manual ? 'SIM ✓' : 'NÃO ✗' }}</div>
                            </div>
                        @endif
                    </div>
                    <div class="cassette-footer">
                        <i class="bi bi-boombox-fill"></i> #UNDERGROUND
                    </div>
                </div>
            </div>

            {{-- COLUNA DIREITA: INFORMAÇÕES PRINCIPAIS + GRÁFICO + REVIEWS --}}
            <div class="col-lg-8">
                {{-- Cabeçalho do item (título + artista) --}}
                <div class="hero-item-header mb-4">
                    <div class="chaos-tag mb-2">
                        <i class="bi bi-megaphone-fill"></i> RELÍQUIA GARIMPAVA
                    </div>
                    <h1 class="item-title-glitch">{{ $item->titulo }}</h1>
                    @if($item->artista_diretor)
                        <h3 class="item-subtitle">{{ $item->artista_diretor }}</h3>
                    @endif
                    <div class="rating-summary mt-3">
                        <div class="stars-big">
                            @php
                                $full = floor($averageRating);
                                $half = ($averageRating - $full) >= 0.5;
                                $empty = 5 - $full - ($half ? 1 : 0);
                            @endphp
                            @for($i=0; $i<$full; $i++) <i class="bi bi-star-fill"></i> @endfor
                            @if($half) <i class="bi bi-star-half"></i> @endif
                            @for($i=0; $i<$empty; $i++) <i class="bi bi-star"></i> @endfor
                        </div>
                        <div class="rating-numbers">
                            <span class="rating-average">{{ number_format($averageRating, 1) }}</span>
                            <span class="rating-count">({{ $reviewsCount }} avaliações)</span>
                        </div>
                    </div>
                </div>

                {{-- Detalhes adicionais (produtora, elenco, descrição) --}}
                <div class="info-panel mb-4">
                    <div class="info-row">
                        <i class="bi bi-building"></i> <strong>Produtora:</strong> {{ $item->empresa_produtora ?? 'Não informada' }}
                    </div>
                    @if($item->elenco_detalhes)
                        <div class="info-row">
                            <i class="bi bi-people-fill"></i> <strong>Elenco/Detalhes:</strong> {{ $item->elenco_detalhes }}
                        </div>
                    @endif
                    <div class="info-row description">
                        <i class="bi bi-chat-left-quote-fill"></i> <strong>Descrição:</strong>
                        <p class="mt-1">{{ $item->descricao ?? 'Sem descrição adicional.' }}</p>
                    </div>
                </div>

                {{-- GRÁFICO DE DISTRIBUIÇÃO DAS NOTAS (estilo "stats do caos") --}}
                <div class="stats-graph mb-4">
                    <div class="stats-header">
                        <i class="bi bi-bar-chart-steps"></i> DISTRIBUIÇÃO DOS GRITOS
                        <div class="stats-line"></div>
                    </div>
                    <canvas id="ratingChart" style="max-height: 250px; width: 100%;"></canvas>
                </div>

                {{-- SEÇÃO DE REVIEWS (ÚLTIMOS GRITOS SOBRE O ITEM) --}}
                <div class="scream-section">
                    <div class="scream-section-header">
                        <i class="bi bi-chat-left-text-fill"></i> ÚLTIMOS GRITOS SOBRE ESTA RELÍQUIA
                        <div class="scream-line"></div>
                    </div>

                    @if($reviews && $reviews->count())
                        <div class="scream-list">
                            @foreach($reviews as $review)
                                <div class="scream-card-horizontal">
                                    <div class="scream-avatar">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <div class="scream-content">
                                        <div class="scream-user">
                                            <strong>{{ $review->user->name }}</strong>
                                            <div class="scream-stars">
                                                @for($i=1;$i<=5;$i++)
                                                    <i class="bi bi-star-fill {{ $i <= $review->nota ? 'active' : '' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="scream-text">“{{ $review->comentario }}”</p>
                                        <div class="scream-footer">
                                            <span class="scream-date">{{ $review->created_at->diffForHumans() }}</span>
                                            @if(auth()->id() === $review->user_id)
                                                <div class="scream-actions">
                                                    <a href="{{ route('reviews.edit', $review) }}" class="text-warning me-2"><i class="bi bi-pencil-fill"></i></a>
                                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir este grito?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn-delete-link"><i class="bi bi-trash3-fill"></i></button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($reviews->hasPages())
                            <div class="pagination-custom mt-3">
                                {{ $reviews->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    @else
                        <div class="scream-empty">
                            <i class="bi bi-mic-mute"></i>
                            <p>Ninguém gritou sobre este item ainda.</p>
                            <small>Seja o primeiro a dar sua opinião!</small>
                        </div>
                    @endif
                </div>

                {{-- BOTÕES DE AÇÃO --}}
                <div class="action-bar mt-4">
                    @auth
                        @php
                            $userHasInterest = $item->interests()
                                ->where('user_id', auth()->id())
                                ->whereIn('status', ['pendente', 'alugado'])
                                ->exists();
                        @endphp

                        @if($userHasInterest)
                            <button class="btn-secondary-disabled" disabled>
                                <i class="bi bi-heart-fill"></i> INTERESSADO
                            </button>
                        @else
                            <a href="{{ route('interests.create', $item) }}" class="btn-skull">
                                <i class="bi bi-heart"></i> TENHO INTERESSE
                            </a>
                        @endif

                        <a href="{{ route('reviews.create', $item->id) }}" class="btn-rust-outline">
                            <i class="bi bi-chat-dots"></i> DAR MEU GRITO
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-skull">ENTRAR PARA INTERESSE</a>
                        <a href="{{ route('login') }}" class="btn-rust-outline">ENTRAR PARA AVALIAR</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ===== BACKGROUND UNDERGROUND ===== */
.item-detail-bg {
    background: radial-gradient(circle at 30% 10%, #0f0f0f, #050505);
    min-height: 100vh;
    padding: 1rem 0;
}

/* ===== CASSETE CARD (COLUNA ESQUERDA) ===== */
.cassette-card {
    background: #111;
    border: 2px solid #2a2a2a;
    box-shadow: 8px 8px 0 rgba(0,0,0,0.4);
    transition: 0.2s;
    overflow: hidden;
}
.cassette-card:hover {
    transform: translateY(-4px);
    border-color: #e6b800;
}
.cassette-cover {
    height: 280px;
    overflow: hidden;
    background: #0a0a0a;
}
.cassette-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.3s;
}
.cassette-card:hover .cassette-img {
    transform: scale(1.03);
}
.cassette-no-img {
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #1a1a1a;
    color: #b91c1c;
    gap: 10px;
}
.cassette-no-img i { font-size: 3rem; }
.cassette-body { padding: 1.5rem; }
.cassette-label {
    font-size: 0.7rem;
    font-weight: bold;
    text-transform: uppercase;
    color: #e6b800;
    border-left: 3px solid #b91c1c;
    padding-left: 10px;
    margin-bottom: 1rem;
}
.tech-list {
    list-style: none;
    padding: 0;
}
.tech-list li {
    margin-bottom: 12px;
    font-size: 0.85rem;
    color: #ccc;
}
.tech-list i {
    width: 24px;
    color: #b91c1c;
}
.price-highlight {
    color: #e6b800;
    font-weight: bold;
    font-size: 1.1rem;
}
.condition-box {
    background: #0a0a0a;
    padding: 12px;
    margin-top: 15px;
    border-left: 3px solid #e6b800;
}
.condition-title {
    font-size: 0.7rem;
    font-weight: bold;
    text-transform: uppercase;
    color: #e6b800;
    margin-bottom: 8px;
}
.condition-item {
    font-size: 0.75rem;
    color: #aaa;
    margin-bottom: 4px;
}
.condition-item span { color: #b91c1c; font-weight: bold; }
.cassette-footer {
    background: #0a0a0a;
    border-top: 1px dashed #2a2a2a;
    padding: 8px;
    text-align: center;
    font-size: 0.65rem;
    color: #666;
}
.cassette-footer i { margin-right: 5px; color: #b91c1c; }

/* ===== CABEÇALHO DO ITEM ===== */
.hero-item-header {
    position: relative;
    padding-bottom: 15px;
    border-bottom: 2px solid #2a2a2a;
}
.chaos-tag {
    display: inline-block;
    background: #b91c1c;
    padding: 4px 12px;
    font-size: 0.65rem;
    font-weight: 900;
    letter-spacing: 1px;
    color: white;
}
.item-title-glitch {
    font-family: 'Rock Salt', cursive;
    font-size: 2.2rem;
    font-weight: 900;
    text-transform: uppercase;
    background: linear-gradient(45deg, #e6b800, #b91c1c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin: 10px 0 5px;
}
.item-subtitle {
    font-size: 1rem;
    color: #aaa;
    margin-bottom: 10px;
}
.rating-summary {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}
.stars-big i {
    font-size: 1.5rem;
    color: #e6b800;
    margin-right: 2px;
}
.rating-average {
    font-size: 1.8rem;
    font-weight: bold;
    color: #e6b800;
}
.rating-count {
    color: #888;
    font-size: 0.8rem;
}

/* ===== INFO PANEL ===== */
.info-panel {
    background: #0a0a0a;
    border: 1px solid #2a2a2a;
    padding: 1rem;
}
.info-row {
    margin-bottom: 12px;
    font-size: 0.85rem;
    color: #ccc;
}
.info-row i {
    width: 24px;
    color: #b91c1c;
}
.info-row.description p {
    background: #111;
    padding: 8px 12px;
    border-left: 3px solid #e6b800;
    font-style: italic;
    margin-top: 5px;
}

/* ===== GRÁFICO ESTILIZADO ===== */
.stats-graph {
    background: #0a0a0a;
    border: 1px solid #2a2a2a;
    padding: 1rem;
}
.stats-header {
    font-size: 0.8rem;
    font-weight: bold;
    color: #e6b800;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}
.stats-line {
    flex: 1;
    height: 2px;
    background: linear-gradient(90deg, #e6b800, transparent);
}

/* ===== SEÇÃO DE REVIEWS (GRITOS) ===== */
.scream-section {
    background: #0a0a0a;
    border: 1px solid #2a2a2a;
    padding: 1rem;
    margin-top: 1rem;
}
.scream-section-header {
    font-size: 0.8rem;
    font-weight: bold;
    color: #e6b800;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}
.scream-line {
    flex: 1;
    height: 2px;
    background: #b91c1c;
}
.scream-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.scream-card-horizontal {
    display: flex;
    gap: 15px;
    background: #111;
    border-left: 4px solid #b91c1c;
    padding: 12px;
    transition: 0.1s;
}
.scream-card-horizontal:hover {
    background: #1a1a1a;
    transform: translateX(5px);
}
.scream-avatar i {
    font-size: 2rem;
    color: #e6b800;
}
.scream-content {
    flex: 1;
}
.scream-user {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    align-items: baseline;
    margin-bottom: 5px;
}
.scream-user strong {
    color: #e6b800;
    font-size: 0.85rem;
}
.scream-stars i {
    font-size: 0.7rem;
    margin: 0 1px;
}
.scream-stars i.active { color: #e6b800; }
.scream-text {
    font-size: 0.85rem;
    color: #ddd;
    font-style: italic;
    margin: 8px 0;
}
.scream-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.7rem;
    color: #666;
}
.scream-actions {
    display: flex;
    gap: 8px;
}
.btn-delete-link {
    background: none;
    border: none;
    color: #b91c1c;
    font-size: 0.8rem;
    cursor: pointer;
}
.btn-delete-link:hover { color: #e6b800; }
.scream-empty {
    text-align: center;
    padding: 2rem;
}
.scream-empty i {
    font-size: 2.5rem;
    color: #b91c1c;
}

/* ===== BOTÕES DE AÇÃO ===== */
.action-bar {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}
.btn-skull, .btn-rust-outline, .btn-secondary-disabled {
    padding: 10px 22px;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 0.75rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: 0.1s;
}
.btn-skull {
    background: #b91c1c;
    color: white;
    clip-path: polygon(0% 0%, 100% 0%, 95% 100%, 0% 100%);
    border: none;
}
.btn-skull:hover {
    background: #e6b800;
    color: black;
    transform: translateX(3px);
}
.btn-rust-outline {
    background: transparent;
    border: 2px solid #e6b800;
    color: #e6b800;
    clip-path: polygon(5% 0%, 100% 0%, 95% 100%, 0% 100%);
}
.btn-rust-outline:hover {
    background: #e6b800;
    color: black;
    transform: translateX(-3px);
}
.btn-secondary-disabled {
    background: #333;
    color: #aaa;
    cursor: not-allowed;
    clip-path: polygon(0% 0%, 100% 0%, 95% 100%, 0% 100%);
}
.btn-rust-outline-sm {
    background: transparent;
    border: 1px solid #e6b800;
    color: #e6b800;
    padding: 6px 14px;
    font-size: 0.7rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.btn-rust-outline-sm:hover {
    background: #e6b800;
    color: black;
}

/* ===== PAGINAÇÃO ===== */
.pagination-custom .pagination {
    --bs-pagination-bg: #111;
    --bs-pagination-color: #e6b800;
    --bs-pagination-active-bg: #e6b800;
    --bs-pagination-active-border-color: #e6b800;
}

/* ===== RESPONSIVO ===== */
@media (max-width: 768px) {
    .item-title-glitch { font-size: 1.5rem; }
    .stars-big i { font-size: 1rem; }
    .rating-average { font-size: 1.2rem; }
    .action-bar { justify-content: center; }
    .scream-card-horizontal { flex-direction: column; }
    .scream-avatar { text-align: center; }
    .scream-user { flex-direction: column; gap: 5px; }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('ratingChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['1 ⭐', '2 ⭐', '3 ⭐', '4 ⭐', '5 ⭐'],
                datasets: [{
                    label: 'Nº de avalições',
                    data: @json(array_values($ratingDistribution)),
                    backgroundColor: ['#b42b2b', '#d46b2b', '#d4a017', '#2b9c4a', '#1e6ec5'],
                    borderRadius: 0,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { labels: { color: '#ece4db', font: { size: 10 } } }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        stepSize: 1, 
                        grid: { color: '#3a2e28' }, 
                        ticks: { color: '#ece4db' } 
                    },
                    x: { 
                        ticks: { color: '#ece4db' }, 
                        grid: { display: false } 
                    }
                }
            }
        });
    });
</script>
@endpush