@extends('layouts.app')

@section('content')
<div class="underground-bg">
    
    <!-- HERO SECTION EXPLOSIVO -->
    <div class="hero-explosion">
        <div class="container py-5">
            <!-- INDICADOR DE FILTRO ATIVO (TIPO DE MÍDIA) -->
            @if(request()->has('tipo_midia') && request()->get('tipo_midia'))
                <div class="active-filter-badge mb-3">
                    <i class="bi bi-funnel-fill me-2"></i>
                    FILTRANDO POR: 
                    <strong>
                        @if(request()->get('tipo_midia') == 'Música') 🎵 MÚSICA
                        @elseif(request()->get('tipo_midia') == 'Filme') 🎬 FILME
                        @elseif(request()->get('tipo_midia') == 'Jogo') 🎮 JOGO
                        @endif
                    </strong>
                    <a href="{{ route('home') }}" class="ms-3 clear-filter-link">
                        <i class="bi bi-x-circle"></i> LIMPAR
                    </a>
                </div>
            @else
                <div class="active-filter-badge muted mb-3">
                    <i class="bi bi-grid-3x3-gap-fill me-2"></i>
                    TODAS AS MÍDIAS
                </div>
            @endif

            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <div class="chaos-badge mb-3">
                        <span>⚡ EDIÇÃO LIMITADA ⚡</span>
                    </div>
                    <h1 class="hero-title">
                        <span class="hero-title-broken">BARGANHA</span>
                        <span class="hero-title-blood">OU MORTE!</span>
                    </h1>
                    <div class="hero-quote">
                        <i class="bi bi-quote"></i>
                        <p>{{ $fraseDestaque ?? 'O caos tem preço, mas aqui é barganha.' }}</p>
                        <i class="bi bi-quote text-end"></i>
                    </div>
                    <div class="hero-buttons mt-4">
                        <a href="#vitrine" class="btn-skull">
                            <i class="bi bi-lightning-charge-fill me-2"></i> EXPLODIR VITRINE
                            <span class="btn-skull-blood"></span>
                        </a>
                        <a href="{{ route('categories.index') }}" class="btn-rust">
                            <i class="bi bi-tags-fill me-2"></i> CATEGORIAS
                        </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="stats-container">
                        <div class="stats-header">
                            <i class="bi bi-bar-chart-steps"></i>
                            <span>STATS DO CAOS</span>
                        </div>
                        <div class="stats-chart">
                            @isset($chartDonut)
                                {!! $chartDonut->container() !!}
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- GRÁFICO DE TIPO DE MÍDIA (Chart.js) --}}
    <div class="container mt-4">
        <div class="second-chart-wrapper">
            <div class="second-chart-header">
                <i class="bi bi-vinyl-fill"></i> TIPO DE MÍDIA
                <div class="blood-line"></div>
            </div>
            <div class="second-chart-inner">
                <canvas id="midiaChart" style="height: 350px; width: 100%;"></canvas>
            </div>
        </div>
    </div>

    <!-- CONTEÚDO PRINCIPAL: SIDEBAR + VITRINE -->
    <div class="container mt-5">
        <div class="row">
            <!-- SIDEBAR (MURAL DE GRITOS + FILTROS) -->
            <div class="col-lg-3 order-lg-1 mb-5">
                <div class="scream-wall">
                    <div class="scream-wall-header">
                        <i class="bi bi-chat-left-text-fill"></i>
                        <h4>ÚLTIMOS GRITOS</h4>
                        <div class="scream-wall-line"></div>
                    </div>
                    
                    @forelse($recentReviews ?? [] as $index => $review)
                        <a href="{{ route('items.show', $review->item->id) }}" class="scream-card-link">
                            <div class="scream-card">
                                <div class="scream-card-header">
                                    <div class="scream-user">
                                        <i class="bi bi-person-circle"></i>
                                        <strong>{{ $review->user->name }}</strong>
                                    </div>
                                    <div class="scream-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star-fill {{ $i <= $review->nota ? 'active' : '' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div class="scream-item">
                                    <i class="bi bi-vinyl-fill"></i> {{ Str::limit($review->item->titulo, 35) }}
                                </div>
                                <p class="scream-text">"{{ Str::limit($review->comentario, 65) }}"</p>
                                <div class="scream-footer">
                                    <span class="scream-number">#{{ $index + 1 }}</span>
                                    <span class="scream-time">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="scream-empty">
                            <i class="bi bi-mic-mute"></i>
                            <p>Silêncio absoluto...</p>
                            <small>Seja o primeiro a gritar!</small>
                        </div>
                    @endforelse

                    <!-- Filtros (destacando o tipo ativo) -->
                    <div class="filter-wall mt-4">
                        <div class="filter-wall-header">
                            <i class="bi bi-funnel-fill"></i>
                            <span>FILTRAR POR TIPO</span>
                        </div>
                        <div class="filter-options">
                            @php $tipoAtivo = request()->get('tipo_midia'); @endphp
                            @foreach(['Música', 'Filme', 'Jogo'] as $tipo)
                                <a href="{{ route('home', array_merge(request()->except('tipo_midia'), ['tipo_midia' => $tipo])) }}" 
                                   class="filter-option {{ $tipoAtivo == $tipo ? 'active' : '' }}">
                                    @if($tipo == 'Música') 🎵 @elseif($tipo == 'Filme') 🎬 @else 🎮 @endif
                                    {{ $tipo }}
                                    <i class="bi bi-arrow-right-circle"></i>
                                </a>
                            @endforeach
                            <a href="{{ route('home', request()->except('tipo_midia')) }}" class="filter-reset">🧨 LIMPAR FILTROS</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- VITRINE PRINCIPAL -->
            <div class="col-lg-9 order-lg-2" id="vitrine">
                <div class="vitrine-header">
                    <div class="vitrine-title">
                        <div class="vitrine-blink"></div>
                        <h2>ITENS GARIMPADOS</h2>
                    </div>
                    <div class="vitrine-controls">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <form method="GET" action="{{ route('home') }}" class="d-inline">
                                <input type="text" name="search" placeholder="BUSCAR RELÍQUIA..." value="{{ $search ?? '' }}">
                                @if(request()->has('sort')) <input type="hidden" name="sort" value="{{ request()->sort }}"> @endif
                                @if(request()->has('category_id')) <input type="hidden" name="category_id" value="{{ request()->category_id }}"> @endif
                                @if(request()->has('tipo_midia')) <input type="hidden" name="tipo_midia" value="{{ request()->tipo_midia }}"> @endif
                            </form>
                        </div>
                        <div class="sort-box">
                            <form method="GET" action="{{ route('home') }}">
                                <select name="sort" onchange="this.form.submit()">
                                    <option value="latest" {{ ($sort ?? 'latest') == 'latest' ? 'selected' : '' }}>🔥 MAIS RECENTES</option>
                                    <option value="price_asc" {{ ($sort ?? '') == 'price_asc' ? 'selected' : '' }}>💰 MENOR PREÇO</option>
                                    <option value="price_desc" {{ ($sort ?? '') == 'price_desc' ? 'selected' : '' }}>💎 MAIOR PREÇO</option>
                                </select>
                                @if(request()->has('search')) <input type="hidden" name="search" value="{{ request()->search }}"> @endif
                                @if(request()->has('category_id')) <input type="hidden" name="category_id" value="{{ request()->category_id }}"> @endif
                                @if(request()->has('tipo_midia')) <input type="hidden" name="tipo_midia" value="{{ request()->tipo_midia }}"> @endif
                            </form>
                        </div>
                    </div>
                </div>

                <div class="vitrine-grid">
                    @forelse($items ?? [] as $item)
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
                                    <p>{{ $item->artista_diretor }}</p>
                                </div>
                            </div>
                            <a href="{{ route('items.show', $item->id) }}" class="item-link"></a>
                        </div>
                    @empty
                        <div class="empty-garimpo">
                            <i class="bi bi-emoji-frown-fill"></i>
                            <h3>NADA ENCONTRADO!</h3>
                            <p>Tente outros filtros ou palavras-chave.</p>
                        </div>
                    @endforelse
                </div>

                <div class="pagination-custom mt-5">
                    {{ ($items ?? collect())->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- SEÇÃO: RARIDADES DO MOMENTO (APÓS A VITRINE) -->
    @isset($featuredItems)
        <div class="container mt-5 pt-4">
            <div class="cassette-section">
                <div class="cassette-header">
                    <div class="cassette-icon"></div>
                    <h2 class="cassette-title">RARIDADES DO MOMENTO</h2>
                    <div class="cassette-tape"></div>
                </div>
                <div class="row g-4 mt-2">
                    @foreach($featuredItems as $item)
                        <div class="col-md-3 col-6">
                            <a href="{{ route('items.show', $item->id) }}" class="rarity-card-link">
                                <div class="rarity-card">
                                    <div class="rarity-image">
                                        @if($item->capa)
                                            <img src="{{ asset('storage/' . $item->capa) }}" alt="{{ $item->titulo }}">
                                        @else
                                            <div class="rarity-no-image">
                                                <i class="bi bi-question-octagon-fill"></i>
                                            </div>
                                        @endif
                                        <div class="rarity-price">R$ {{ number_format($item->preco, 2, ',', '.') }}</div>
                                    </div>
                                    <div class="rarity-info">
                                        <span class="rarity-category">{{ $item->category->nome }}</span>
                                        <h6>{{ Str::limit($item->titulo, 25) }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endisset

    <!-- BANNER COMUNIDADE (NO FINAL DA PÁGINA) -->
    <div class="graffiti-banner my-5">
        <div class="container">
            <div class="graffiti-inner">
                <div class="graffiti-text">
                    <span class="graffiti-tag">#UNDERGROUND</span>
                    <h3>COMUNIDADE DO CAOS</h3>
                    <p>Colecionadores, punks, headbangers e gamers. Seu lugar é aqui.</p>
                </div>
                <a href="#" class="graffiti-button">
                    <i class="bi bi-discord me-2"></i> ENTRAR NO CAOS
                    <i class="bi bi-arrow-right-circle ms-2"></i>
                </a>
            </div>
        </div>
    </div>

</div> <!-- fim underground-bg -->
@endsection

@push('styles')
<style>
/* ===== ESTILOS UNDERGROUND ÚNICOS DA HOME ===== */

.second-chart-header {
    color: #b91c1c;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 2px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.blood-line {
    flex: 1;
    height: 2px;
    background: linear-gradient(90deg, #b91c1c, transparent);
}

.underground-bg {
    background: radial-gradient(circle at 30% 10%, #0f0f0f, #050505);
    position: relative;
    overflow-x: hidden;
}

/* Hero Explosion */
.hero-explosion {
    background: linear-gradient(135deg, #0a0a0a 0%, #1a0f0a 100%);
    border-bottom: 4px solid #b91c1c;
    position: relative;
    overflow: hidden;
    margin-top: -1.5rem;
    margin-bottom: 2rem;
    padding: 2rem 0;
}

/* Badge de filtro ativo */
.active-filter-badge {
    display: inline-flex;
    align-items: center;
    background: #1a1a1a;
    border-left: 5px solid #e6b800;
    padding: 8px 18px;
    font-size: 0.8rem;
    text-transform: uppercase;
    font-weight: bold;
    color: #e6b800;
}
.active-filter-badge.muted {
    border-left-color: #555;
    color: #aaa;
}
.clear-filter-link {
    color: #b91c1c;
    text-decoration: none;
    font-size: 0.7rem;
    transition: 0.1s;
}
.clear-filter-link:hover {
    color: #e6b800;
}

.chaos-badge {
    display: inline-block;
    background: #b91c1c;
    padding: 5px 15px;
    font-size: 0.7rem;
    font-weight: 900;
    letter-spacing: 2px;
    transform: rotate(-3deg);
}

.hero-title {
    font-family: 'Rock Salt', cursive;
    font-size: 4rem;
    line-height: 1.1;
    margin: 20px 0;
}

.hero-title-broken {
    background: linear-gradient(45deg, #e6b800, #b91c1c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hero-title-blood {
    color: #b91c1c;
    text-shadow: 3px 3px 0 #e6b800;
}

.hero-quote {
    background: rgba(0,0,0,0.5);
    border-left: 5px solid #e6b800;
    padding: 15px 20px;
    font-style: italic;
    color: #aaa;
    margin: 20px 0;
}

.hero-quote i:first-child {
    margin-right: 10px;
    color: #e6b800;
}
.hero-quote i:last-child {
    margin-left: 10px;
    color: #e6b800;
    display: block;
    text-align: right;
}

.btn-skull {
    background: #b91c1c;
    color: white;
    padding: 12px 28px;
    text-decoration: none;
    font-weight: 900;
    text-transform: uppercase;
    display: inline-block;
    position: relative;
    transition: 0.1s;
    clip-path: polygon(0% 0%, 100% 0%, 95% 100%, 0% 100%);
}
.btn-skull:hover {
    background: #e6b800;
    color: black;
    transform: translateX(-3px);
}

.btn-rust {
    background: transparent;
    border: 3px solid #e6b800;
    color: #e6b800;
    padding: 10px 26px;
    text-decoration: none;
    font-weight: 900;
    text-transform: uppercase;
    display: inline-block;
    transition: 0.1s;
    clip-path: polygon(5% 0%, 100% 0%, 95% 100%, 0% 100%);
}
.btn-rust:hover {
    background: #e6b800;
    color: black;
    transform: translateX(3px);
}

.stats-container {
    background: #151515;
    border: 2px dashed #e6b800;
    padding: 15px;
    transform: rotate(1deg);
    transition: 0.2s;
}
.stats-container:hover {
    transform: rotate(0deg) scale(1.01);
}
.stats-header {
    font-size: 0.7rem;
    font-weight: bold;
    text-transform: uppercase;
    color: #e6b800;
    text-align: center;
    margin-bottom: 10px;
    letter-spacing: 2px;
}

.second-chart-wrapper {
    background: #111;
    border: 1px solid #2a2a2a;
    padding: 15px;
    margin-top: -20px;
    position: relative;
    z-index: 1;
}

/* Banner comunidade */
.graffiti-banner {
    background: linear-gradient(135deg, #1a1a1a, #0a0a0a);
    border-top: 3px dashed #e6b800;
    border-bottom: 3px dashed #e6b800;
    padding: 20px 0;
}
.graffiti-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}
.graffiti-tag {
    font-family: 'Rock Salt', cursive;
    font-size: 0.8rem;
    color: #b91c1c;
}
.graffiti-text h3 {
    font-size: 1.5rem;
    font-weight: 900;
    text-transform: uppercase;
    margin: 5px 0;
}
.graffiti-button {
    background: #e6b800;
    color: black;
    padding: 12px 25px;
    text-decoration: none;
    font-weight: 900;
    text-transform: uppercase;
    transition: 0.1s;
}
.graffiti-button:hover {
    background: #b91c1c;
    color: white;
    transform: scale(1.05);
}

/* Seção raridades (cassete) */
.cassette-section {
    margin: 40px 0;
}
.cassette-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}
.cassette-icon {
    width: 40px;
    height: 30px;
    background: linear-gradient(90deg, #b91c1c, #e6b800);
    position: relative;
    border-radius: 4px;
}
.cassette-icon::before {
    content: "";
    position: absolute;
    top: 5px;
    left: 10px;
    width: 10px;
    height: 10px;
    background: white;
    border-radius: 50%;
}
.cassette-title {
    font-size: 1.3rem;
    font-weight: 900;
    text-transform: uppercase;
    margin: 0;
    color: #b91c1c;
}
.cassette-tape {
    flex: 1;
    height: 2px;
    background: linear-gradient(90deg, #e6b800, transparent);
}

.rarity-card-link {
    text-decoration: none;
}
.rarity-card {
    background: #151515;
    border: 1px solid #2a2a2a;
    transition: 0.2s;
    overflow: hidden;
}
.rarity-card:hover {
    transform: translateY(-5px);
    border-color: #e6b800;
}
.rarity-image {
    height: 180px;
    overflow: hidden;
    position: relative;
}
.rarity-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.3s;
}
.rarity-card:hover .rarity-image img {
    transform: scale(1.05);
}
.rarity-price {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: #e6b800;
    color: black;
    padding: 3px 10px;
    font-size: 0.8rem;
    font-weight: bold;
    transform: rotate(3deg);
}
.rarity-info {
    padding: 12px;
    text-align: center;
}
.rarity-category {
    font-size: 0.7rem;
    background: #b91c1c;
    padding: 2px 8px;
    display: inline-block;
    margin-bottom: 8px;
}
.rarity-info h6 {
    font-size: 0.85rem;
    font-weight: 900;
    text-transform: uppercase;
    color: #e6b800;
    margin: 0;
}

/* Sidebar */
.scream-wall {
    background: #0a0a0a;
    border: 1px solid #2a2a2a;
    padding: 20px;
}
.scream-wall-header {
    text-align: center;
    margin-bottom: 20px;
}
.scream-wall-header i {
    font-size: 2rem;
    color: #b91c1c;
}
.scream-wall-header h4 {
    font-size: 1rem;
    font-weight: 900;
    text-transform: uppercase;
    margin: 5px 0;
}
.scream-wall-line {
    width: 40px;
    height: 3px;
    background: #e6b800;
    margin: 10px auto;
}
.scream-card-link {
    text-decoration: none;
}
.scream-card {
    background: #111;
    border-left: 3px solid #b91c1c;
    padding: 12px;
    margin-bottom: 15px;
    transition: 0.1s;
}
.scream-card:hover {
    background: #1a1a1a;
    transform: translateX(5px);
}
.scream-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}
.scream-user i {
    font-size: 0.8rem;
    margin-right: 5px;
    color: #b91c1c;
}
.scream-user strong {
    font-size: 0.75rem;
    text-transform: uppercase;
}
.scream-rating i {
    font-size: 0.6rem;
    margin: 0 1px;
}
.scream-rating i.active {
    color: #e6b800;
}
.scream-item {
    font-size: 0.7rem;
    color: #888;
    margin-bottom: 5px;
}
.scream-text {
    font-size: 0.75rem;
    color: #ccc;
    font-style: italic;
    margin-bottom: 8px;
}
.scream-footer {
    display: flex;
    justify-content: space-between;
    font-size: 0.65rem;
}
.scream-number {
    color: #b91c1c;
    font-weight: bold;
}
.scream-time {
    color: #666;
}
.scream-empty {
    text-align: center;
    padding: 30px 0;
}

/* Filtros laterais */
.filter-wall {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #2a2a2a;
}
.filter-wall-header {
    text-align: center;
    margin-bottom: 15px;
}
.filter-options {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.filter-option {
    background: #111;
    padding: 10px;
    text-decoration: none;
    color: white;
    font-size: 0.8rem;
    font-weight: bold;
    text-transform: uppercase;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #2a2a2a;
    transition: 0.1s;
}
.filter-option.active {
    background: #e6b800;
    color: black;
    border-color: #e6b800;
}
.filter-option:hover {
    background: #e6b800;
    color: black;
    border-color: #e6b800;
}
.filter-reset {
    background: #b91c1c;
    color: white;
    text-decoration: none;
    padding: 10px;
    text-align: center;
    font-weight: bold;
    font-size: 0.8rem;
    text-transform: uppercase;
    display: block;
    margin-top: 5px;
    transition: 0.1s;
}
.filter-reset:hover {
    background: #e6b800;
    color: black;
}

/* Vitrine principal */
.vitrine-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #2a2a2a;
}
.vitrine-title {
    display: flex;
    align-items: center;
    gap: 10px;
}
.vitrine-blink {
    width: 12px;
    height: 12px;
    background: #b91c1c;
    border-radius: 50%;
    animation: blink 1s infinite;
}
.vitrine-title h2 {
    font-size: 1.5rem;
    font-weight: 900;
    text-transform: uppercase;
    margin: 0;
}
.vitrine-controls {
    display: flex;
    gap: 10px;
}
.search-box {
    background: #151515;
    border: 1px solid #2a2a2a;
    padding: 5px 10px;
    display: flex;
    align-items: center;
}
.search-box i {
    color: #e6b800;
    margin-right: 8px;
}
.search-box input {
    background: transparent;
    border: none;
    color: white;
    padding: 5px;
    width: 150px;
}
.search-box input:focus { outline: none; }
.search-box input::placeholder {
    color: #666;
    font-size: 0.7rem;
    letter-spacing: 1px;
}
.sort-box select {
    background: #151515;
    border: 1px solid #2a2a2a;
    color: white;
    padding: 7px 12px;
    font-size: 0.7rem;
    font-weight: bold;
    cursor: pointer;
}
.sort-box select:focus {
    outline: none;
    border-color: #e6b800;
}

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
    border-color: #e6b800;
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
    background: #e6b800;
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
    color: #e6b800;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 2px;
}
.item-info {
    padding: 15px;
}
.item-category {
    font-size: 0.65rem;
    background: #b91c1c;
    padding: 2px 8px;
    display: inline-block;
    margin-bottom: 8px;
}
.item-info h5 {
    font-size: 0.9rem;
    font-weight: 900;
    text-transform: uppercase;
    color: #e6b800;
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
}
.empty-garimpo i {
    font-size: 3rem;
    color: #666;
}
.empty-garimpo h3 {
    margin-top: 15px;
    font-size: 1.2rem;
}

.pagination-custom .pagination {
    --bs-pagination-bg: #111;
    --bs-pagination-color: #e6b800;
    --bs-pagination-active-bg: #e6b800;
    --bs-pagination-active-border-color: #e6b800;
    --bs-pagination-hover-bg: #b91c1c;
    --bs-pagination-hover-color: white;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0; }
}

@media (max-width: 768px) {
    .hero-title { font-size: 2.5rem; }
    .vitrine-header { flex-direction: column; }
    .vitrine-controls { width: 100%; justify-content: center; }
    .graffiti-inner { flex-direction: column; text-align: center; }
}
</style>
@endpush

@push('scripts')
@isset($chartDonut)
    <script src="{{ $chartDonut->cdn() }}"></script>
    {{ $chartDonut->script() }}
@endisset

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.querySelectorAll('select[name="sort"]').forEach(select => {
        select.addEventListener('change', () => select.closest('form').submit());
    });

    // Gráfico de tipo de mídia (Chart.js)
    @isset($midiaLabels)
    const midiaCtx = document.getElementById('midiaChart')?.getContext('2d');
    if (midiaCtx) {
        new Chart(midiaCtx, {
            type: 'bar',
            data: {
                labels: @json($midiaLabels),
                datasets: [{
                    label: 'Itens',
                    data: @json($midiaData),
                    backgroundColor: ['#e6b800', '#b91c1c', '#2b9c4a'],
                    borderWidth: 0,
                    borderRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { backgroundColor: '#1a1a1a', titleColor: '#e6b800', bodyColor: '#ece4db' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1,
                        grid: { color: '#3a2e28' },
                        ticks: { color: '#ece4db' }
                    },
                    x: {
                        ticks: { color: '#e6b800', font: { weight: 'bold' } },
                        grid: { display: false }
                    }
                }
            }
        });
    }
    @endisset
</script>
@endpush