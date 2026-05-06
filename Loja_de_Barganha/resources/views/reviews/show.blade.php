@extends('layouts.app')

@section('title', 'Grito de ' . $review->user->name)

@section('content')
<div class="review-bg">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="review-card">
                    <div class="review-card-header">
                        <div class="chaos-tag mb-2">
                            <i class="bi bi-mic-fill"></i> GRITO SELVAGEM
                        </div>
                        <h2 class="review-title">
                            <span class="title-broken">ESCUTEM O</span>
                            <span class="title-blood">CAOS</span>
                        </h2>
                        <div class="scream-line"></div>
                    </div>

                    <div class="review-card-body">
                        <!-- Informações do autor e item -->
                        <div class="review-meta-header d-flex justify-content-between align-items-center flex-wrap mb-4">
                            <div class="reviewer">
                                <i class="bi bi-person-circle text-warning me-2"></i>
                                <strong>{{ $review->user->name }}</strong>
                                <span class="mx-2">•</span>
                                <span class="text-dim">{{ $review->created_at->format('d/m/Y \à\s H:i') }}</span>
                            </div>
                            <a href="{{ route('items.show', $review->item) }}" class="item-link-light">
                                <i class="bi bi-box-arrow-up-right"></i> Ver item
                            </a>
                        </div>

                        <!-- Item detalhado -->
                        <div class="item-preview-show mb-4">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-2">
                                    @if($review->item->capa)
                                        <img src="{{ asset('storage/' . $review->item->capa) }}" class="show-item-img" alt="{{ $review->item->titulo }}">
                                    @else
                                        <div class="show-no-img"><i class="bi bi-vinyl-fill"></i></div>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <span class="item-badge">{{ $review->item->category->nome ?? 'Mídia' }}</span>
                                    <h4 class="item-title-show">{{ $review->item->titulo }}</h4>
                                    <p class="item-artist-show">{{ $review->item->artista_diretor }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Classificação -->
                        <div class="rating-box mb-4">
                            <div class="rating-label">
                                <i class="bi bi-star-fill"></i> CLASSIFICAÇÃO DO GRITO
                            </div>
                            <div class="rating-stars-big">
                                @for($i=1;$i<=5;$i++)
                                    <i class="bi bi-star-fill {{ $i <= $review->nota ? 'text-warning' : 'text-secondary opacity-25' }}"></i>
                                @endfor
                                <span class="rating-number">({{ $review->nota }}/5)</span>
                            </div>
                        </div>

                        <!-- Comentário -->
                        <div class="comment-box">
                            <div class="comment-quote">
                                <i class="bi bi-quote"></i>
                                <p class="lead">“{{ $review->comentario }}”</p>
                                <i class="bi bi-quote rotate-quote"></i>
                            </div>
                        </div>

                        <!-- Botões de ação (apenas para o autor) -->
                        @if(auth()->check() && auth()->id() === $review->user_id)
                            <div class="action-buttons mt-4 d-flex gap-3 justify-content-end">
                                <a href="{{ route('reviews.edit', $review) }}" class="btn-rust-outline-sm">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </a>
                                <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Excluir este grito permanentemente?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-skull-sm">
                                        <i class="bi bi-trash3-fill"></i> Excluir
                                    </button>
                                </form>
                            </div>
                        @endif

                        <!-- Link de voltar -->
                        <div class="text-center mt-5">
                            <a href="{{ route('communities.index') }}" class="btn-rust-outline">
                                <i class="bi bi-arrow-left"></i> VOLTAR À COMUNIDADE
                            </a>
                        </div>
                    </div>

                    <div class="review-card-footer">
                        <div class="chaos-stamp"><i class="bi bi-boombox-fill"></i> #UNDERGROUND</div>
                        <div class="chaos-stamp"><i class="bi bi-vinyl-fill"></i> BARGANHA OU MORTE</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Reaproveita os estilos base da edit, adicionando específicos para show */
.review-bg, .review-card, .review-card-header, .chaos-tag, .review-title, .scream-line, .review-card-body, .review-card-footer { /* mesmo da edit */ }
.review-meta-header { border-bottom: 1px solid #2a2a2a; padding-bottom: 10px; margin-bottom: 20px; }
.text-dim { color: #888; font-size: 0.75rem; }
.item-link-light { color: #e6b800; text-decoration: none; font-size: 0.75rem; }
.item-link-light:hover { text-decoration: underline; }
.item-preview-show { background: #0a0a0a; padding: 1rem; border: 1px solid #2a2a2a; }
.show-item-img { width: 80px; height: 80px; object-fit: cover; border: 2px solid #e6b800; border-radius: 5px; }
.show-no-img { width: 80px; height: 80px; background: #1a1a1a; display: flex; align-items: center; justify-content: center; border: 1px dashed #b91c1c; color: #b91c1c; }
.item-title-show { font-size: 1.2rem; font-weight: 900; color: #e6b800; margin: 5px 0; }
.item-artist-show { font-size: 0.8rem; color: #aaa; margin: 0; }
.rating-box { background: #0a0a0a; padding: 15px; border-left: 5px solid #e6b800; }
.rating-label { font-size: 0.7rem; text-transform: uppercase; color: #e6b800; margin-bottom: 8px; }
.rating-stars-big i { font-size: 1.5rem; margin-right: 5px; }
.rating-number { margin-left: 10px; font-size: 0.9rem; color: #ccc; }
.comment-box { background: #111; padding: 20px; border: 1px solid #2a2a2a; margin-top: 20px; }
.comment-quote { position: relative; }
.comment-quote i:first-child { font-size: 2rem; color: #b91c1c; opacity: 0.5; position: absolute; top: -10px; left: -5px; }
.comment-quote .rotate-quote { transform: rotate(180deg); bottom: -10px; right: -5px; top: auto; left: auto; position: absolute; font-size: 2rem; color: #b91c1c; opacity: 0.5; }
.comment-quote p { font-size: 1.1rem; padding: 10px 25px; color: #eee; margin: 0; }
.btn-rust-outline-sm { background: transparent; border: 2px solid #e6b800; color: #e6b800; padding: 6px 18px; text-decoration: none; font-weight: bold; font-size: 0.7rem; text-transform: uppercase; transition: 0.1s; display: inline-flex; align-items: center; gap: 5px; }
.btn-rust-outline-sm:hover { background: #e6b800; color: black; }
.btn-skull-sm { background: #b91c1c; color: white; border: none; padding: 6px 18px; font-weight: bold; font-size: 0.7rem; text-transform: uppercase; cursor: pointer; transition: 0.1s; display: inline-flex; align-items: center; gap: 5px; }
.btn-skull-sm:hover { background: #e6b800; color: black; }
@media (max-width: 768px) { .rating-stars-big i { font-size: 1rem; } .comment-quote p { font-size: 0.9rem; } }
</style>
@endpush