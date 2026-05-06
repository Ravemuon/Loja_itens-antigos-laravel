@extends('layouts.app')

@section('content')
<div class="review-bg">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- CARD PRINCIPAL NO ESTILO "MURAL DE GRITOS" -->
                <div class="review-card">
                    <div class="review-card-header">
                        <div class="chaos-tag mb-2">
                            <i class="bi bi-megaphone-fill"></i> AVALIAÇÃO PESADA
                        </div>
                        <h2 class="review-title">
                            <span class="title-broken">GRITE SUA</span>
                            <span class="title-blood">OPINIÃO</span>
                        </h2>
                        <div class="review-subtitle">
                            <i class="bi bi-record-fill"></i> {{ $item->titulo }}
                        </div>
                        <div class="scream-line"></div>
                    </div>

                    <div class="review-card-body">
                        <!-- INFORMAÇÕES DO ITEM (ESTILO FICHA TÉCNICA) -->
                        <div class="item-preview mb-4">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-3">
                                    @if($item->capa)
                                        <img src="{{ asset('storage/' . $item->capa) }}" class="img-fluid review-img" alt="{{ $item->titulo }}">
                                    @else
                                        <div class="review-no-img">
                                            <i class="bi bi-disc-fill"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <div class="item-badge">{{ $item->category->nome ?? 'Sem categoria' }}</div>
                                    <h3 class="item-title">{{ $item->titulo }}</h3>
                                    <p class="item-description">{{ Str::limit($item->descricao, 120) }}</p>
                                    <div class="item-meta">
                                        <span><i class="bi bi-person-badge"></i> {{ $item->artista_diretor ?? 'Anônimo' }}</span>
                                        <span><i class="bi bi-cash-stack"></i> R$ {{ number_format($item->preco, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="scream-divider">
                            <span>✪ ESCREVA SEU GRITO ✪</span>
                        </div>

                        <!-- FORMULÁRIO DE AVALIAÇÃO -->
                        <form action="{{ route('reviews.store', $item->id) }}" method="POST" class="review-form">
                            @csrf

                            <!-- NOTA (ESTRELAS INTERATIVAS) -->
                            <div class="form-group mb-4">
                                <label class="form-label-custom">
                                    <i class="bi bi-star-fill"></i> SUA NOTA (1 a 5)
                                </label>
                                <div class="star-rating">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="nota" value="{{ $i }}" {{ old('nota') == $i ? 'checked' : '' }} required>
                                        <label for="star{{ $i }}" title="{{ $i }} estrelas">★</label>
                                    @endfor
                                </div>
                                @error('nota')
                                    <div class="invalid-feedback-custom">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- COMENTÁRIO -->
                            <div class="form-group mb-4">
                                <label class="form-label-custom">
                                    <i class="bi bi-chat-quote-fill"></i> SEU GRITO
                                </label>
                                <textarea name="comentario" id="comentario" rows="5" 
                                    class="scream-textarea @error('comentario') is-invalid-custom @enderror" 
                                    placeholder="Escreva aqui sua opinião brutal... (mínimo 5 caracteres)" required>{{ old('comentario') }}</textarea>
                                @error('comentario')
                                    <div class="invalid-feedback-custom">{{ $message }}</div>
                                @enderror
                                <div class="form-hint">
                                    <i class="bi bi-info-circle"></i> Mínimo de 5 caracteres. Quanto mais sincero, melhor!
                                </div>
                            </div>

                            <!-- BOTÕES -->
                            <div class="form-actions">
                                <a href="{{ route('items.show', $item->id) }}" class="btn-rust-outline">
                                    <i class="bi bi-arrow-left"></i> VOLTAR
                                </a>
                                <button type="submit" class="btn-skull">
                                    <i class="bi bi-mic-fill"></i> PUBLICAR GRITO
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- RODAPÉ CAÓTICO -->
                    <div class="review-card-footer">
                        <div class="chaos-stamp">
                            <i class="bi bi-boombox-fill"></i> #UNDERGROUND
                        </div>
                        <div class="chaos-stamp">
                            <i class="bi bi-vinyl-fill"></i> BARGANHA OU MORTE
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* ===== ESTILOS UNDERGROUND PARA PÁGINA DE AVALIAÇÃO ===== */
.review-bg {
    background: radial-gradient(circle at 30% 10%, #0f0f0f, #050505);
    min-height: 100vh;
    padding: 2rem 0;
    position: relative;
}

.review-card {
    background: #111;
    border: 2px solid #2a2a2a;
    box-shadow: 10px 10px 0 rgba(0,0,0,0.5);
    transition: 0.2s;
    margin: 20px 0;
}

.review-card-header {
    background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%);
    border-bottom: 3px solid #b91c1c;
    padding: 1.5rem 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.review-card-header::before {
    content: "⚡";
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 2rem;
    opacity: 0.3;
    transform: rotate(-15deg);
}

.review-card-header::after {
    content: "⚡";
    position: absolute;
    bottom: 10px;
    right: 10px;
    font-size: 2rem;
    opacity: 0.3;
    transform: rotate(15deg);
}

.chaos-tag {
    display: inline-block;
    background: #b91c1c;
    padding: 5px 15px;
    font-size: 0.7rem;
    font-weight: 900;
    letter-spacing: 2px;
    transform: rotate(-2deg);
    color: white;
}

.review-title {
    font-family: 'Rock Salt', cursive;
    font-size: 2.2rem;
    margin: 15px 0 5px;
}

.title-broken {
    background: linear-gradient(45deg, #e6b800, #b91c1c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.title-blood {
    color: #b91c1c;
    text-shadow: 2px 2px 0 #e6b800;
}

.review-subtitle {
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #e6b800;
    font-weight: bold;
    margin-top: 10px;
}

.scream-line {
    width: 80px;
    height: 3px;
    background: #e6b800;
    margin: 15px auto 0;
    position: relative;
}

.scream-line::before,
.scream-line::after {
    content: "";
    position: absolute;
    width: 10px;
    height: 10px;
    background: #b91c1c;
    top: -3px;
    border-radius: 50%;
}

.scream-line::before { left: -15px; }
.scream-line::after { right: -15px; }

.review-card-body {
    padding: 2rem;
}

/* Preview do item */
.item-preview {
    background: #0a0a0a;
    border: 1px solid #2a2a2a;
    padding: 1.5rem;
}

.review-img {
    border: 3px solid #e6b800;
    transform: rotate(1deg);
    transition: 0.2s;
}

.review-img:hover {
    transform: rotate(0deg) scale(1.02);
}

.review-no-img {
    background: #1a1a1a;
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px dashed #b91c1c;
    color: #b91c1c;
}

.review-no-img i {
    font-size: 3rem;
}

.item-badge {
    display: inline-block;
    background: #b91c1c;
    font-size: 0.65rem;
    padding: 3px 10px;
    text-transform: uppercase;
    font-weight: bold;
    margin-bottom: 10px;
}

.item-title {
    font-size: 1.4rem;
    font-weight: 900;
    color: #e6b800;
    margin-bottom: 8px;
    text-transform: uppercase;
}

.item-description {
    font-size: 0.85rem;
    color: #aaa;
    margin-bottom: 10px;
}

.item-meta {
    display: flex;
    gap: 20px;
    font-size: 0.75rem;
    color: #888;
}

.item-meta i {
    color: #b91c1c;
    margin-right: 5px;
}

/* Divisor */
.scream-divider {
    text-align: center;
    margin: 30px 0 20px;
    position: relative;
}

.scream-divider span {
    background: #111;
    padding: 0 20px;
    font-size: 0.8rem;
    font-weight: bold;
    color: #e6b800;
    letter-spacing: 3px;
}

.scream-divider::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #2a2a2a;
    z-index: -1;
}

/* Estrelas interativas */
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 5px;
}

.star-rating input {
    display: none;
}

.star-rating label {
    font-size: 2rem;
    color: #444;
    cursor: pointer;
    transition: 0.1s;
}

.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input:checked ~ label {
    color: #e6b800;
    text-shadow: 0 0 5px #e6b800;
}

/* Formulário */
.form-group {
    margin-bottom: 1.8rem;
}

.form-label-custom {
    display: block;
    font-size: 0.8rem;
    font-weight: bold;
    text-transform: uppercase;
    color: #e6b800;
    margin-bottom: 10px;
    letter-spacing: 1px;
}

.form-label-custom i {
    margin-right: 8px;
    color: #b91c1c;
}

.scream-textarea {
    width: 100%;
    background: #0a0a0a;
    border: 2px solid #2a2a2a;
    padding: 12px;
    color: #f0f0f0;
    font-size: 0.9rem;
    resize: vertical;
    transition: 0.1s;
}

.scream-textarea:focus {
    outline: none;
    border-color: #e6b800;
    box-shadow: 0 0 0 2px rgba(230,184,0,0.3);
}

.scream-textarea.is-invalid-custom {
    border-color: #b91c1c;
}

.invalid-feedback-custom {
    color: #b91c1c;
    font-size: 0.75rem;
    margin-top: 5px;
    font-weight: bold;
}

.form-hint {
    font-size: 0.7rem;
    color: #777;
    margin-top: 6px;
}

.form-hint i {
    margin-right: 4px;
}

/* Botões */
.form-actions {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-top: 30px;
}

.btn-rust-outline {
    background: transparent;
    border: 3px solid #e6b800;
    color: #e6b800;
    padding: 10px 24px;
    text-decoration: none;
    font-weight: 900;
    text-transform: uppercase;
    font-size: 0.8rem;
    transition: 0.1s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    clip-path: polygon(5% 0%, 100% 0%, 95% 100%, 0% 100%);
}

.btn-rust-outline:hover {
    background: #e6b800;
    color: black;
    transform: translateX(-3px);
}

.btn-skull {
    background: #b91c1c;
    color: white;
    padding: 10px 28px;
    border: none;
    font-weight: 900;
    text-transform: uppercase;
    font-size: 0.8rem;
    cursor: pointer;
    transition: 0.1s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    clip-path: polygon(0% 0%, 100% 0%, 95% 100%, 0% 100%);
}

.btn-skull:hover {
    background: #e6b800;
    color: black;
    transform: translateX(3px);
}

/* Rodapé */
.review-card-footer {
    background: #0a0a0a;
    border-top: 1px dashed #2a2a2a;
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    font-size: 0.65rem;
    color: #666;
}

.chaos-stamp i {
    margin-right: 5px;
    color: #b91c1c;
}

/* Responsivo */
@media (max-width: 768px) {
    .review-title {
        font-size: 1.6rem;
    }
    .form-actions {
        flex-direction: column;
    }
    .btn-rust-outline, .btn-skull {
        justify-content: center;
    }
    .item-meta {
        flex-direction: column;
        gap: 5px;
    }
}
</style>
@endpush

@push('scripts')
<script>
    // Pequeno script para garantir que as estrelas reflitam o valor salvo (caso haja erro de validação)
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('.star-rating input');
        radios.forEach(radio => {
            if (radio.checked) {
                // forçar visual (já é feito pelo CSS)
            }
        });
    });
</script>
@endpush