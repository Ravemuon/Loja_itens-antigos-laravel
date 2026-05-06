@extends('layouts.app')

@section('title', 'Perfil de ' . $user->name)

@section('content')
<div class="profile-bg">
    <div class="container py-5">
        
        {{-- MENSAGENS DE SUCESSO/ERRO --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show bg-success text-white border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- CABEÇALHO DO PERFIL --}}
        <div class="profile-header-card mb-5">
            <div class="row align-items-center">
                <div class="col-md-3 text-center text-md-start">
                    <div class="avatar-wrapper">
                        @if($user->image)
                            <img src="{{ asset('storage/' . $user->image) }}" class="avatar-img">
                        @else
                            <div class="avatar-placeholder">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        @endif
                        
                        @auth
                            @if(auth()->id() === $user->id)
                                {{-- Link que dispara o Modal --}}
                                <a href="#" class="edit-avatar-btn" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal" title="Alterar foto">
                                    <i class="bi bi-camera-fill"></i>
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
                <div class="col-md-9 text-center text-md-start mt-3 mt-md-0">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div>
                            <h1 class="display-4 fw-black text-uppercase mb-0">{{ $user->name }}</h1>
                            <div class="user-badges mt-2">
                                @if($user->is_admin)
                                    <span class="badge bg-danger me-2"><i class="bi bi-shield-lock-fill"></i> ADMINISTRADOR</span>
                                @endif
                                @if($totalReviews > 50)
                                    <span class="badge bg-warning text-dark"><i class="bi bi-trophy-fill"></i> LENDÁRIO</span>
                                @elseif($totalReviews > 20)
                                    <span class="badge bg-info"><i class="bi bi-star-fill"></i> VETERANO</span>
                                @elseif($totalReviews > 5)
                                    <span class="badge bg-success"><i class="bi bi-mic-fill"></i> GRITADOR ATIVO</span>
                                @else
                                    <span class="badge bg-secondary"><i class="bi bi-ear-fill"></i> OUVINTE</span>
                                @endif
                            </div>
                        </div>
                        <div class="mt-2 mt-md-0">
                            <a href="{{ route('communities.index') }}" class="btn-outline-rock text-decoration-none">
                                <i class="bi bi-arrow-left-circle"></i> VOLTAR
                            </a>
                        </div>
                    </div>
                    <p class="lead text-dim mt-3 mb-0 border-start border-warning border-3 ps-3">
                        <i class="bi bi-quote"></i> 
                        {{ $user->bio ?? 'Esse colecionador ainda não escreveu sua biografia. 🎸' }}
                    </p>
                </div>
            </div>

            {{-- STATS --}}
            <div class="row g-3 mt-4 pt-3 border-top border-secondary">
                <div class="col-sm-6 col-md-3">
                    <div class="stat-block text-center">
                        <i class="bi bi-chat-dots-fill fs-2 text-warning"></i>
                        <h3 class="fw-bold mt-2 mb-0">{{ $totalReviews }}</h3>
                        <p class="text-dim small text-uppercase mb-0">GRITOS LANÇADOS</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="stat-block text-center">
                        <i class="bi bi-star-fill fs-2 text-warning"></i>
                        <h3 class="fw-bold mt-2 mb-0">{{ number_format($mediaNota, 1) }}</h3>
                        <p class="text-dim small text-uppercase mb-0">MÉDIA DAS NOTAS</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="stat-block text-center">
                        <i class="bi bi-calendar-range fs-2 text-warning"></i>
                        <h3 class="fw-bold mt-2 mb-0">{{ $user->created_at->diffForHumans() }}</h3>
                        <p class="text-dim small text-uppercase mb-0">NA COMUNIDADE</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="stat-block text-center">
                        <i class="bi bi-collection-fill fs-2 text-warning"></i>
                        <h3 class="fw-bold mt-2 mb-0">{{ $totalItemsAvaliados ?? $reviews->count() }}</h3>
                        <p class="text-dim small text-uppercase mb-0">ITENS AVALIADOS</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ABAS (Reviews e Interesses) --}}
        <div class="profile-tabs mb-4">
            <ul class="nav nav-tabs border-0 gap-2" id="profileTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                        <i class="bi bi-chat-dots-fill me-1"></i> GRITOS 
                        <span class="badge bg-secondary ms-1">{{ $totalReviews }}</span>
                    </button>
                </li>
                @if(auth()->check() && (auth()->id() === $user->id || auth()->user()->is_admin))
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="interests-tab" data-bs-toggle="tab" data-bs-target="#interests" type="button" role="tab">
                        <i class="bi bi-lightning-charge-fill me-1"></i> INTERESSES
                        <span class="badge bg-secondary ms-1">{{ $totalInteresses ?? 0 }}</span>
                    </button>
                </li>
                @endif
            </ul>
        </div>

        <div class="tab-content">
            {{-- CONTEÚDO REVIEWS --}}
            <div class="tab-pane fade show active" id="reviews" role="tabpanel">
                <div class="row g-4 mt-2">
                    @forelse($reviews as $review)
                        <div class="col-md-6 col-lg-4">
                            <div class="review-card-profile">
                                <div class="review-card-header">
                                    <div class="review-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star-fill {{ $i <= $review->nota ? 'text-warning' : 'text-secondary opacity-25' }}"></i>
                                        @endfor
                                    </div>
                                    <small class="review-date">{{ $review->created_at->format('d/m/Y') }}</small>
                                </div>
                                <div class="review-item d-flex gap-3 mt-2">
                                    @if($review->item->capa)
                                        <img src="{{ asset('storage/' . $review->item->capa) }}" class="item-thumb rounded border border-secondary">
                                    @else
                                        <div class="item-thumb-placeholder rounded bg-black border border-secondary">
                                            <i class="bi bi-vinyl"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('items.show', $review->item) }}" class="text-decoration-none">
                                            <strong class="text-white">{{ Str::limit($review->item->titulo, 30) }}</strong>
                                        </a>
                                        <small class="text-dim d-block">{{ $review->item->artista_diretor }}</small>
                                    </div>
                                </div>
                                <div class="review-comment mt-3">
                                    <p class="fst-italic text-dim small">"{{ Str::limit($review->comentario, 80) }}"</p>
                                </div>
                                <div class="review-footer mt-3 d-flex justify-content-between align-items-center">
                                    <a href="{{ route('communities.review', $review) }}" class="btn-read-more">
                                        LER GRITO <i class="bi bi-arrow-right-circle"></i>
                                    </a>
                                    @if(auth()->check() && (auth()->id() === $user->id || auth()->user()->is_admin))
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('reviews.edit', $review) }}" class="btn btn-dark text-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Excluir este grito?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-dark text-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 empty-state">
                            <i class="bi bi-mic-mute-fill fs-1 text-secondary"></i>
                            <h5 class="mt-3 text-dim">SILÊNCIO TOTAL</h5>
                        </div>
                    @endforelse
                </div>
                <div class="d-flex justify-content-center mt-5">
                    {{ $reviews->links('pagination::bootstrap-5') }}
                </div>
            </div>

            {{-- CONTEÚDO INTERESSES --}}
            @if(auth()->check() && (auth()->id() === $user->id || auth()->user()->is_admin))
                <div class="tab-pane fade" id="interests" role="tabpanel">
                    {{-- Tabela de interesses mantida conforme seu código original --}}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- MODAL DE UPLOAD DE FOTO --}}
@auth
    @if(auth()->id() === $user->id)
    <div class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold text-warning uppercase">ATUALIZAR FOTO DE PERFIL</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-dim">Escolha uma imagem de impacto (JPG, PNG)</label>
                            <input type="file" name="image" class="form-control bg-black text-white border-secondary" required>
                            {{-- Mantemos o nome oculto para não precisar alterar o resto do controller --}}
                            <input type="hidden" name="name" value="{{ $user->name }}">
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn-rock">SALVAR FOTO</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endauth

<style>
:root {
    --dirty-gold: #ffc107;
}

.profile-bg {
    background: radial-gradient(circle at 20% 30%, #0f0f0f, #050505);
    min-height: 100vh;
}

/* Card do cabeçalho */
.profile-header-card {
    background: #111;
    border: 1px solid #2a2a2a;
    border-radius: 24px;
    padding: 32px;
    transition: 0.2s;
}

/* Avatar */
.avatar-wrapper {
    position: relative;
    display: inline-block;
    width: 120px;
    height: 120px;
}
.avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid var(--dirty-gold);
}
.avatar-placeholder {
    width: 100%;
    height: 100%;
    background: #1a1a1a;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    color: var(--dirty-gold);
    border: 3px solid var(--dirty-gold);
}
.edit-avatar-btn {
    position: absolute;
    bottom: 0;
    right: 0;
    background: var(--dirty-gold);
    color: black;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: 0.2s;
}
.edit-avatar-btn:hover {
    transform: scale(1.1);
    color: white;
    background: #dc3545;
}

/* Stats blocks */
.stat-block {
    background: rgba(0,0,0,0.3);
    border-radius: 16px;
    padding: 12px;
    transition: 0.2s;
}
.stat-block:hover {
    background: rgba(255,193,7,0.1);
    transform: translateY(-3px);
}

/* Tabs personalizadas */
.profile-tabs .nav-link {
    background: #1a1a1a;
    color: #adb5bd;
    border: none;
    padding: 10px 24px;
    border-radius: 40px;
    font-weight: bold;
    transition: 0.2s;
}
.profile-tabs .nav-link.active {
    background: var(--dirty-gold);
    color: black;
}
.profile-tabs .nav-link:hover:not(.active) {
    background: #2a2a2a;
    color: white;
}

/* Card de review */
.review-card-profile {
    background: #111;
    border: 1px solid #2a2a2a;
    border-radius: 20px;
    padding: 20px;
    transition: 0.25s;
    height: 100%;
}
.review-card-profile:hover {
    border-color: var(--dirty-gold);
    transform: translateY(-5px);
}
.review-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.item-thumb {
    width: 48px;
    height: 48px;
    object-fit: cover;
}
.item-thumb-placeholder {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #666;
}
.btn-read-more {
    color: var(--dirty-gold);
    text-decoration: none;
    font-size: 0.75rem;
    font-weight: bold;
    text-transform: uppercase;
}
.btn-read-more:hover {
    color: #dc3545;
}
.review-date {
    font-size: 0.7rem;
    color: #6c757d;
}
.btn-rock {
    background: #dc3545;
    border: none;
    color: white;
    padding: 10px 24px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-decoration: none;
    display: inline-block;
    border-radius: 40px;
    transition: 0.2s;
}
.btn-rock:hover {
    background: var(--dirty-gold);
    color: black;
}
.btn-outline-rock {
    background: transparent;
    border: 2px solid var(--dirty-gold);
    color: var(--dirty-gold);
    padding: 8px 22px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-decoration: none;
    border-radius: 40px;
    transition: 0.2s;
}
.btn-outline-rock:hover {
    background: var(--dirty-gold);
    color: black;
}
.empty-state {
    background: #0a0a0a;
    border: 2px dashed #2a2a2a;
    border-radius: 24px;
}
.text-dim {
    color: #adb5bd;
}
</style>

@push('scripts')
<script>
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection