@extends('layouts.app')

@section('title', 'Comunidade Underground')

@section('content')
<div class="community-bg">
    <div class="container py-5">
        
        <!-- HEADER COM INFORMAÇÕES DO USUÁRIO -->
        <div class="row align-items-center mb-5">
            <div class="col-md-7">
                <div class="community-header">
                    <i class="bi bi-people-fill fs-1 text-warning rock-flicker"></i>
                    <h1 class="display-4 fw-black text-uppercase mt-2">COMUNIDADE UNDERGROUND</h1>
                    <p class="lead text-dim">Onde colecionadores se encontram, gritam e compartilham suas relíquias</p>
                </div>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                @auth
                    <div class="d-flex gap-2 justify-content-md-end">
                        <a href="{{ route('reviews.index') }}" class="btn btn-warning">
                            <i class="bi bi-chat-dots"></i> MINHAS OPINIÕES
                        </a>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-outline-rock">
                        <i class="bi bi-box-arrow-in-right"></i> ENTRAR PARA GRITAR
                    </a>
                @endauth
            </div>
        </div>
                <!-- NOVA SEÇÃO: "VOCÊ PODE AVALIAR!" (INTERESSES) -->
        @auth
            <div class="interests-section mb-5">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-megaphone-fill fs-3 text-warning"></i>
                    <h2 class="h3 fw-bold text-uppercase mb-0">VOCÊ PODE AVALIAR!</h2>
                    <div class="flex-grow-1 border-bottom border-secondary opacity-25"></div>
                </div>
                
                @if(isset($itensParaAvaliar) && $itensParaAvaliar->count())
                    <div class="row g-4">
                        @foreach($itensParaAvaliar as $item)
                            <div class="col-sm-6 col-lg-3">
                                <div class="suggest-card h-100">
                                    <div class="suggest-card-inner">
                                        <div class="suggest-icon">
                                            <i class="bi bi-vinyl-fill fs-1 opacity-50"></i>
                                        </div>
                                        <h5 class="mt-2 mb-1">{{ $item->titulo }}</h5>
                                        <p class="small text-dim">{{ $item->artista_diretor }}</p>
                                        <div class="suggest-actions mt-auto">
                                            <a href="{{ route('items.show', $item) }}" class="btn-suggest">
                                                AVALIAR AGORA <i class="bi bi-arrow-right-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-secondary bg-dark text-dim border-0">
                        <i class="bi bi-info-circle"></i> Nenhum item disponível para avaliação no momento. 
                        <a href="{{ route('home') }}" class="text-warning">Explore o acervo</a> e seja o primeiro a gritar!
                    </div>
                @endif
            </div>
        @else
            <div class="interests-section mb-5 p-4 text-center bg-dark bg-opacity-25 rounded-3 border border-warning border-opacity-25">
                <i class="bi bi-chat-quote-fill fs-1 text-warning"></i>
                <h3 class="h5 mt-2">Quer sugerir seus interesses?</h3>
                <p class="text-dim">Faça login para ver itens personalizados e avaliar suas relíquias favoritas!</p>
                <a href="{{ route('login') }}" class="btn-outline-rock btn-sm">ENTRAR NA COMUNIDADE</a>
            </div>
        @endauth
        
        <!-- ESTATÍSTICAS DA COMUNIDADE -->
          <div class="d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-megaphone-fill fs-3 text-warning"></i>
            <h2 class="h3 fw-bold text-uppercase mb-0">ESTATÍSTICAS DA COMUNIDADE!</h2>
            <div class="flex-grow-1 border-bottom border-secondary opacity-25"></div>
        </div>
         
        <div class="row g-4 mb-5">
            <div class="col-sm-6 col-lg-3">
                <div class="stat-card text-center p-3">
                    <i class="bi bi-chat-dots-fill fs-2 text-warning"></i>
                    <h3 class="fw-bold mt-2">{{ $totalReviews }}</h3>
                    <p class="text-dim mb-0">GRITOS LANÇADOS</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="stat-card text-center p-3">
                    <i class="bi bi-people-fill fs-2 text-danger"></i>
                    <h3 class="fw-bold mt-2">{{ $totalUsers }}</h3>
                    <p class="text-dim mb-0">COLECIONADORES</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="stat-card text-center p-3">
                    <i class="bi bi-collection-fill fs-2 text-warning"></i>
                    <h3 class="fw-bold mt-2">{{ $totalItems }}</h3>
                    <p class="text-dim mb-0">RELÍQUIAS</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="stat-card text-center p-3">
                    <i class="bi bi-star-fill fs-2 text-warning"></i>
                    <h3 class="fw-bold mt-2">{{ number_format($mediaGeral, 1) }}</h3>
                    <p class="text-dim mb-0">MÉDIA GERAL</p>
                </div>
            </div>
        </div>
        
        <!-- FILTROS E TOP USERS -->
        <div class="row mb-5 align-items-end">
            <div class="col-lg-8">
                <div class="filter-tabs">
                    <a href="{{ route('communities.index', ['tipo' => 'recentes']) }}" 
                       class="filter-tab {{ $tipo == 'recentes' ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i> MAIS RECENTES
                    </a>
                    <a href="{{ route('communities.index', ['tipo' => 'top']) }}" 
                       class="filter-tab {{ $tipo == 'top' ? 'active' : '' }}">
                        <i class="bi bi-trophy-fill"></i> MAIS NOTAS
                    </a>
                </div>
            </div>
            <div class="col-lg-4 mt-3 mt-lg-0">
                <div class="top-users text-lg-end">
                    <h6 class="text-uppercase text-dim mb-2"><i class="bi bi-trophy-fill text-warning"></i> TOP COLECIONADORES</h6>
                    <div class="d-flex gap-2 flex-wrap justify-content-lg-end">
                        @forelse($topUsers as $topUser)
                            <a href="{{ route('communities.profile', $topUser) }}" class="top-user-badge">
                                <i class="bi bi-person-circle"></i> {{ $topUser->name }}
                                <span class="badge bg-warning text-dark">{{ $topUser->reviews_count }}</span>
                            </a>
                        @empty
                            <span class="text-dim">Ainda sem dados</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <!-- GRID DE REVIEWS (GRITOS) -->
        <div class="reviews-section">
            <div class="d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-chat-dots-fill fs-3 text-warning"></i>
                <h2 class="h3 fw-bold text-uppercase mb-0">ÚLTIMOS GRITOS</h2>
                <div class="flex-grow-1 border-bottom border-secondary opacity-25"></div>
            </div>
            
            <div class="row g-4">
                @forelse($reviews as $review)
                    <div class="col-md-6 col-lg-4">
                        <div class="review-card-community h-100">
                            <div class="review-card-header">
                                <div class="review-user">
                                    <a href="{{ route('communities.profile', $review->user) }}" class="text-decoration-none">
                                        <i class="bi bi-person-circle"></i>
                                        <strong>{{ $review->user->name }}</strong>
                                    </a>
                                </div>
                                <div class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star-fill {{ $i <= $review->nota ? 'text-warning' : 'text-secondary opacity-25' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="review-item">
                                <a href="{{ route('items.show', $review->item) }}" class="text-decoration-none">
                                    <i class="bi bi-vinyl-fill me-1"></i>
                                    <span class="fw-semibold">{{ $review->item->titulo }}</span>
                                    <small class="text-dim d-block">por {{ $review->item->artista_diretor }}</small>
                                </a>
                            </div>
                            
                            <div class="review-comment">
                                <i class="bi bi-quote text-warning opacity-50"></i>
                                <p>"{{ Str::limit($review->comentario, 120) }}"</p>
                            </div>
                            
                            <div class="review-footer">
                                <a href="{{ route('reviews.show', $review) }}" class="btn-read-more">
                                    LER GRITO COMPLETO <i class="bi bi-arrow-right-circle"></i>
                                </a>
                                <small class="review-date">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-community text-center py-5">
                            <i class="bi bi-chat-dots-fill fs-1 text-secondary"></i>
                            <h3 class="mt-3">Ainda não há gritos na comunidade!</h3>
                            <p class="text-dim">Seja o primeiro a avaliar um item e fazer barulho.</p>
                            <a href="{{ route('home') }}" class="btn-rock mt-3">EXPLORAR ITENS</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- PAGINAÇÃO -->
        <div class="d-flex justify-content-center mt-5">
            {{ $reviews->appends(['tipo' => $tipo])->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<style>
:root {
    --dirty-gold: #ffc107;
    --rust-red: #dc3545;
    --chalk-white: #f8f9fa;
    --smoke-fade: #adb5bd;
}

.community-bg {
    background: radial-gradient(circle at 20% 30%, #0f0f0f, #030303);
    min-height: 100vh;
}

/* Cards de estatísticas */
.stat-card {
    background: rgba(21, 21, 21, 0.9);
    backdrop-filter: blur(2px);
    border: 1px solid #2a2a2a;
    border-radius: 16px;
    transition: all 0.25s ease;
}
.stat-card:hover {
    border-color: var(--dirty-gold);
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.4);
}

/* Filtros */
.filter-tabs {
    display: flex;
    gap: 8px;
    border-bottom: 2px solid #2a2a2a;
    padding-bottom: 8px;
}
.filter-tab {
    background: transparent;
    border: none;
    color: var(--smoke-fade);
    text-transform: uppercase;
    font-weight: 800;
    letter-spacing: 1px;
    padding: 8px 20px;
    text-decoration: none;
    transition: 0.2s;
    border-radius: 40px;
}
.filter-tab.active {
    color: var(--dirty-gold);
    background: rgba(255,193,7,0.1);
    border-bottom: 3px solid var(--dirty-gold);
}
.filter-tab:hover {
    color: var(--dirty-gold);
}

/* Top users badge */
.top-user-badge {
    background: #1a1a1a;
    padding: 6px 14px;
    border-radius: 40px;
    text-decoration: none;
    color: var(--chalk-white);
    font-size: 0.8rem;
    font-weight: 500;
    transition: 0.2s;
}
.top-user-badge:hover {
    background: var(--dirty-gold);
    color: black;
    transform: scale(1.02);
}

/* Seção "Você pode avaliar!" */
.suggest-card {
    background: #0c0c0c;
    border: 1px solid #2a2a2a;
    border-radius: 20px;
    transition: all 0.25s;
    overflow: hidden;
}
.suggest-card:hover {
    border-color: var(--dirty-gold);
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.5);
}
.suggest-card-inner {
    padding: 20px;
    display: flex;
    flex-direction: column;
    height: 100%;
    text-align: center;
}
.suggest-icon i {
    color: var(--dirty-gold);
}
.suggest-actions {
    margin-top: 1rem;
}
.btn-suggest {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: transparent;
    border: 1px solid var(--dirty-gold);
    color: var(--dirty-gold);
    padding: 6px 16px;
    border-radius: 40px;
    text-decoration: none;
    font-weight: bold;
    font-size: 0.85rem;
    transition: 0.2s;
}
.btn-suggest:hover {
    background: var(--dirty-gold);
    color: black;
}

/* Cards de reviews */
.review-card-community {
    background: #111;
    border: 1px solid #2a2a2a;
    border-radius: 20px;
    padding: 20px;
    transition: all 0.25s;
    display: flex;
    flex-direction: column;
}
.review-card-community:hover {
    border-color: var(--dirty-gold);
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.3);
}
.review-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #2a2a2a;
}
.review-user a {
    color: var(--dirty-gold);
    font-weight: bold;
    text-decoration: none;
}
.review-user a:hover {
    color: var(--rust-red);
}
.review-item {
    margin-bottom: 15px;
}
.review-item a {
    color: white;
    font-weight: 600;
    text-decoration: none;
}
.review-item a:hover {
    color: var(--dirty-gold);
}
.review-comment {
    margin-bottom: 15px;
    flex-grow: 1;
}
.review-comment p {
    font-style: italic;
    color: #ccc;
    font-size: 0.9rem;
    margin: 5px 0 0;
}
.review-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #2a2a2a;
}
.btn-read-more {
    color: var(--dirty-gold);
    text-decoration: none;
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.btn-read-more:hover {
    color: var(--rust-red);
}
.review-date {
    font-size: 0.65rem;
    color: #6c757d;
}

/* componentes genéricos */
.empty-community {
    background: #0a0a0a;
    border: 2px dashed #2a2a2a;
    border-radius: 32px;
}
.btn-rock {
    background: var(--rust-red);
    border: none;
    color: white;
    padding: 10px 28px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: inline-block;
    text-decoration: none;
    transition: 0.2s;
    border-radius: 40px;
}
.btn-rock:hover {
    background: var(--dirty-gold);
    color: black;
}
.btn-outline-rock {
    background: transparent;
    border: 2px solid var(--dirty-gold);
    color: var(--dirty-gold);
    padding: 8px 24px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-decoration: none;
    transition: 0.2s;
    border-radius: 40px;
    display: inline-block;
}
.btn-outline-rock:hover {
    background: var(--dirty-gold);
    color: black;
}
.text-dim {
    color: #adb5bd;
}
@media (max-width: 768px) {
    .filter-tabs { justify-content: center; }
    .top-users { text-align: center !important; }
    .top-users .d-flex { justify-content: center !important; }
    .btn-outline-rock, .btn-rock { font-size: 0.8rem; padding: 6px 16px; }
}
</style>
@endsection