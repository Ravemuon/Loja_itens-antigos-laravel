@extends('layouts.app')

@section('title', 'Meus gritos')

@section('content')
<div class="community-bg">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">
            <div class="page-title-caos">
                <i class="bi bi-megaphone-fill me-2"></i>
                <h1 class="d-inline-block text-uppercase fw-black">MEUS GRITOS</h1>
                <div class="title-rust-line"></div>
            </div>
            <a href="{{ route('communities.index') }}" class="btn-rust-outline">
                <i class="bi bi-people-fill"></i> COMUNIDADE
            </a>
        </div>

        @if($reviews->count())
            <div class="row g-4">
                @foreach($reviews as $review)
                    <div class="col-md-6 col-lg-4">
                        <div class="scream-card-profile">
                            <div class="scream-header">
                                <div class="rating-stars">
                                    @for($i=1;$i<=5;$i++)
                                        <i class="bi bi-star-fill {{ $i <= $review->nota ? 'text-warning' : 'text-secondary opacity-25' }}"></i>
                                    @endfor
                                </div>
                                <div class="scream-date">{{ $review->created_at->format('d/m/Y') }}</div>
                            </div>
                            <div class="scream-item-info">
                                <h5>{{ $review->item->titulo }}</h5>
                                <span class="item-artist">{{ $review->item->artista_diretor }}</span>
                            </div>
                            <div class="scream-quote">
                                <i class="bi bi-quote"></i>
                                <p>"{{ Str::limit($review->comentario, 80) }}"</p>
                            </div>
                            <div class="scream-actions">
                                <a href="{{ route('reviews.show', $review) }}" class="btn-sm btn-outline-rock">VER GRITO</a>
                                <div class="action-icons">
                                    <a href="{{ route('reviews.edit', $review) }}" class="text-warning me-2" title="Editar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir este grito? Essa ação é irreversível.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-icon" title="Excluir">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination-custom mt-5">
                {{ $reviews->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="empty-community text-center py-5">
                <div class="empty-icon">
                    <i class="bi bi-chat-dots-fill"></i>
                </div>
                <h3>SILÊNCIO ABSOLUTO</h3>
                <p>Você ainda não avaliou nenhum item.</p>
                <a href="{{ route('home') }}#vitrine" class="btn-skull mt-3">
                    <i class="bi bi-lightning-charge-fill"></i> DAR MEU PRIMEIRO GRITO
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.community-bg { background: radial-gradient(circle at 30% 10%, #0f0f0f, #050505); min-height: 100vh; }
.page-title-caos { position: relative; }
.page-title-caos h1 { font-size: 2rem; color: #e6b800; text-shadow: 2px 2px 0 #b91c1c; letter-spacing: 2px; }
.title-rust-line { width: 60px; height: 3px; background: #b91c1c; margin-top: 5px; }
.btn-rust-outline { background: transparent; border: 2px solid #e6b800; color: #e6b800; padding: 8px 20px; text-decoration: none; font-weight: bold; text-transform: uppercase; font-size: 0.75rem; transition: 0.1s; display: inline-flex; align-items: center; gap: 8px; }
.btn-rust-outline:hover { background: #e6b800; color: black; transform: translateX(-3px); }
.scream-card-profile { background: #111; border: 1px solid #2a2a2a; padding: 1.2rem; transition: 0.2s; }
.scream-card-profile:hover { border-color: #e6b800; transform: translateY(-5px); }
.scream-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
.rating-stars i { font-size: 0.8rem; margin-right: 2px; }
.scream-date { font-size: 0.65rem; color: #666; }
.scream-item-info h5 { font-size: 1rem; font-weight: 900; color: #e6b800; text-transform: uppercase; margin-bottom: 5px; }
.item-artist { font-size: 0.7rem; color: #888; }
.scream-quote { background: #0a0a0a; padding: 10px; margin: 12px 0; border-left: 3px solid #b91c1c; }
.scream-quote i { color: #b91c1c; font-size: 0.8rem; }
.scream-quote p { font-style: italic; font-size: 0.8rem; color: #ccc; margin: 5px 0 0; }
.scream-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 10px; }
.btn-outline-rock { background: transparent; border: 1px solid #e6b800; color: #e6b800; padding: 5px 12px; text-decoration: none; font-size: 0.7rem; font-weight: bold; transition: 0.1s; }
.btn-outline-rock:hover { background: #e6b800; color: black; }
.action-icons a, .btn-delete-icon { background: transparent; border: none; color: #b91c1c; font-size: 1rem; cursor: pointer; transition: 0.1s; }
.action-icons a:hover, .btn-delete-icon:hover { color: #e6b800; transform: scale(1.1); }
.btn-delete-icon { background: none; border: none; padding: 0; }
.empty-community { background: #0a0a0a; border: 2px dashed #2a2a2a; padding: 3rem; }
.empty-icon i { font-size: 4rem; color: #b91c1c; }
.empty-community h3 { font-size: 1.5rem; margin: 15px 0 5px; color: #e6b800; }
.btn-skull { background: #b91c1c; color: white; padding: 10px 24px; text-decoration: none; font-weight: 900; text-transform: uppercase; display: inline-flex; align-items: center; gap: 8px; clip-path: polygon(0% 0%, 100% 0%, 95% 100%, 0% 100%); transition: 0.1s; }
.btn-skull:hover { background: #e6b800; color: black; transform: translateX(3px); }
.pagination-custom .pagination { --bs-pagination-bg: #111; --bs-pagination-color: #e6b800; --bs-pagination-active-bg: #e6b800; --bs-pagination-active-border-color: #e6b800; }
</style>
@endpush