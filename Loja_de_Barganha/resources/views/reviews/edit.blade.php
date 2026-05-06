@extends('layouts.app')

@section('title', 'Editar grito')

@section('content')
<div class="review-bg">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- CARD EDIT -->
                <div class="review-card">
                    <div class="review-card-header">
                        <div class="chaos-tag mb-2">
                            <i class="bi bi-pencil-fill"></i> EDITANDO GRITO
                        </div>
                        <h2 class="review-title">
                            <span class="title-broken">RASGUE A</span>
                            <span class="title-blood">OPINIÃO</span>
                        </h2>
                        <div class="scream-line"></div>
                    </div>

                    <div class="review-card-body">
                        <!-- Info do item avaliado -->
                        <div class="item-preview-mini mb-4">
                            <div class="d-flex align-items-center gap-3">
                                @if($review->item->capa)
                                    <img src="{{ asset('storage/' . $review->item->capa) }}" class="edit-item-img" alt="{{ $review->item->titulo }}">
                                @else
                                    <div class="edit-no-img">
                                        <i class="bi bi-vinyl-fill"></i>
                                    </div>
                                @endif
                                <div>
                                    <span class="item-badge">{{ $review->item->category->nome ?? 'Mídia' }}</span>
                                    <h5 class="item-title-small">{{ $review->item->titulo }}</h5>
                                    <p class="item-meta-small">{{ $review->item->artista_diretor }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="scream-divider">
                            <span>✪ REESCREVA SEU GRITO ✪</span>
                        </div>

                        <form action="{{ route('reviews.update', $review) }}" method="POST" class="review-form">
                            @csrf
                            @method('PUT')

                            <!-- Nota com estrelas interativas -->
                            <div class="form-group mb-4">
                                <label class="form-label-custom">
                                    <i class="bi bi-star-fill"></i> NOTA (1 a 5)
                                </label>
                                <div class="star-rating">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="nota" value="{{ $i }}" {{ $review->nota == $i ? 'checked' : '' }} required>
                                        <label for="star{{ $i }}" title="{{ $i }} estrelas">★</label>
                                    @endfor
                                </div>
                                @error('nota')
                                    <div class="invalid-feedback-custom">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Comentário -->
                            <div class="form-group mb-4">
                                <label class="form-label-custom">
                                    <i class="bi bi-chat-quote-fill"></i> SEU GRITO
                                </label>
                                <textarea name="comentario" rows="5" 
                                    class="scream-textarea @error('comentario') is-invalid-custom @enderror" 
                                    placeholder="Escreva sua opinião brutal..." required>{{ old('comentario', $review->comentario) }}</textarea>
                                @error('comentario')
                                    <div class="invalid-feedback-custom">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Botões -->
                            <div class="form-actions">
                                <a href="{{ route('communities.index') }}" class="btn-rust-outline">
                                    <i class="bi bi-arrow-left"></i> CANCELAR
                                </a>
                                <button type="submit" class="btn-skull">
                                    <i class="bi bi-lightning-charge-fill"></i> ATUALIZAR GRITO
                                </button>
                            </div>
                        </form>
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
/* Mesmo estilo da página de criação (já incluído globalmente ou repetido aqui) */
.review-bg { background: radial-gradient(circle at 30% 10%, #0f0f0f, #050505); min-height: 100vh; padding: 2rem 0; }
.review-card { background: #111; border: 2px solid #2a2a2a; box-shadow: 10px 10px 0 rgba(0,0,0,0.5); }
.review-card-header { background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%); border-bottom: 3px solid #b91c1c; padding: 1.5rem 2rem; text-align: center; position: relative; overflow: hidden; }
.chaos-tag { display: inline-block; background: #b91c1c; padding: 5px 15px; font-size: 0.7rem; font-weight: 900; letter-spacing: 2px; transform: rotate(-2deg); color: white; }
.review-title { font-family: 'Rock Salt', cursive; font-size: 2rem; margin: 15px 0 5px; }
.title-broken { background: linear-gradient(45deg, #e6b800, #b91c1c); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.title-blood { color: #b91c1c; text-shadow: 2px 2px 0 #e6b800; }
.scream-line { width: 80px; height: 3px; background: #e6b800; margin: 15px auto 0; position: relative; }
.review-card-body { padding: 2rem; }
.item-preview-mini { background: #0a0a0a; border: 1px solid #2a2a2a; padding: 1rem; }
.edit-item-img { width: 60px; height: 60px; object-fit: cover; border: 2px solid #e6b800; }
.edit-no-img { width: 60px; height: 60px; background: #1a1a1a; display: flex; align-items: center; justify-content: center; border: 1px dashed #b91c1c; color: #b91c1c; }
.item-badge { background: #b91c1c; font-size: 0.6rem; padding: 2px 8px; }
.item-title-small { font-size: 1rem; margin: 5px 0 0; color: #e6b800; }
.item-meta-small { font-size: 0.7rem; color: #888; margin: 0; }
.scream-divider { text-align: center; margin: 20px 0; position: relative; }
.scream-divider span { background: #111; padding: 0 15px; font-size: 0.7rem; color: #e6b800; letter-spacing: 2px; }
.star-rating { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 5px; }
.star-rating input { display: none; }
.star-rating label { font-size: 2rem; color: #444; cursor: pointer; transition: 0.1s; }
.star-rating label:hover, .star-rating label:hover ~ label, .star-rating input:checked ~ label { color: #e6b800; text-shadow: 0 0 5px #e6b800; }
.form-label-custom { font-size: 0.8rem; font-weight: bold; text-transform: uppercase; color: #e6b800; margin-bottom: 10px; display: block; }
.scream-textarea { width: 100%; background: #0a0a0a; border: 2px solid #2a2a2a; padding: 12px; color: #f0f0f0; resize: vertical; }
.scream-textarea:focus { border-color: #e6b800; outline: none; }
.invalid-feedback-custom { color: #b91c1c; font-size: 0.75rem; margin-top: 5px; }
.form-actions { display: flex; justify-content: space-between; gap: 20px; margin-top: 30px; }
.btn-rust-outline { background: transparent; border: 3px solid #e6b800; color: #e6b800; padding: 10px 24px; text-decoration: none; font-weight: 900; text-transform: uppercase; font-size: 0.8rem; clip-path: polygon(5% 0%, 100% 0%, 95% 100%, 0% 100%); }
.btn-rust-outline:hover { background: #e6b800; color: black; transform: translateX(-3px); }
.btn-skull { background: #b91c1c; color: white; padding: 10px 28px; border: none; font-weight: 900; text-transform: uppercase; font-size: 0.8rem; cursor: pointer; clip-path: polygon(0% 0%, 100% 0%, 95% 100%, 0% 100%); }
.btn-skull:hover { background: #e6b800; color: black; transform: translateX(3px); }
.review-card-footer { background: #0a0a0a; border-top: 1px dashed #2a2a2a; padding: 1rem 2rem; display: flex; justify-content: space-between; font-size: 0.65rem; color: #666; }
@media (max-width: 768px) { .form-actions { flex-direction: column; } .btn-rust-outline, .btn-skull { justify-content: center; text-align: center; } }
</style>
@endpush