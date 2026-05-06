<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>BARGANHA | Underground Collection - Grunge & Rock Shop</title>
    
    <!-- Bootstrap 5 + Icons + Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Special+Elite&family=Oswald:wght@400;500;700;900&family=Montserrat:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        /* ------------------------------------------------------------
           GRUNGE DARK CORE - ROCK SOUL (ESTILOS GLOBAIS)
        ------------------------------------------------------------ */
        :root {
            --grunge-bg: #0c0b0a;
            --grunge-card: #151210;
            --rust-red: #b42b2b;
            --dirty-gold: #d4a017;
            --lead-gray: #2c2a27;
            --chalk-white: #ece4db;
            --smoke-fade: #6e6a65;
            --blood-splash: #8b1e1e;
            --grunge-border: #3a2e28;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #050403;
            font-family: 'Montserrat', sans-serif;
            color: var(--chalk-white);
            position: relative;
            transition: background-image 0.3s ease;
        }

        /* FUNDO DINÂMICO POR TIPO DE MÍDIA */
        body.musica-bg {
            background-image: radial-gradient(circle at 20% 30%, #1a0a0a 0%, #050403 100%);
        }
        body.filme-bg {
            background-image: radial-gradient(circle at 20% 30%, #0a1a1a 0%, #050403 100%);
        }
        body.jogo-bg {
            background-image: radial-gradient(circle at 20% 30%, #1a1a0a 0%, #050403 100%);
        }
        body.default-bg {
            background-image: radial-gradient(circle at 20% 30%, #1e1612 0%, #050403 100%);
        }

        /* Camada de textura sobre o fundo */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://www.transparenttextures.com/patterns/black-scales.png');
            opacity: 0.18;
            pointer-events: none;
            z-index: 0;
        }

        /* ===== LATERAIS COM IMAGENS GRUNGE ===== */
        .side-grunge {
            position: fixed;
            top: 0;
            bottom: 0;
            width: 110px;
            z-index: 10;
            pointer-events: none;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            opacity: 0.55;
            filter: grayscale(0.3) contrast(1.2);
            transition: opacity 0.3s;
        }

        .side-grunge.left {
            left: 0;
            background-image: url('https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?q=80&w=1769&auto=format');
            background-position: 30% center;
            mask-image: linear-gradient(to right, black 70%, transparent);
            -webkit-mask-image: linear-gradient(to right, black 70%, transparent);
        }

        .side-grunge.right {
            right: 0;
            background-image: url('https://images.unsplash.com/photo-1524368535928-5b5e00ddc76b?q=80&w=1770&auto=format');
            background-position: 70% center;
            mask-image: linear-gradient(to left, black 70%, transparent);
            -webkit-mask-image: linear-gradient(to left, black 70%, transparent);
        }

        @media (max-width: 1200px) {
            .side-grunge { width: 60px; opacity: 0.4; }
        }
        @media (max-width: 768px) {
            .side-grunge { display: none; }
        }

        /* navbar rasgada */
        .navbar-grunge {
            background: #070503e6;
            backdrop-filter: blur(8px);
            border-bottom: 3px solid var(--rust-red);
            box-shadow: 0 12px 28px -12px black;
            padding: 0.8rem 0;
            z-index: 1030;
        }

        .navbar-brand {
            font-family: 'Special Elite', cursive;
            font-size: 1.9rem;
            letter-spacing: 4px;
            color: var(--dirty-gold) !important;
            text-shadow: 3px 3px 0px #5e1a1a;
            transition: all 0.2s;
        }
        .navbar-brand:hover {
            text-shadow: 4px 4px 0px var(--blood-splash);
            transform: scale(1.01);
        }

        .nav-link {
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 0.85rem;
            color: #ddd2c5 !important;
            margin: 0 10px;
            position: relative;
            transition: 0.2s;
        }
        .nav-link:hover {
            color: var(--dirty-gold) !important;
            letter-spacing: 2px;
        }

        /* Botão hambúrguer estilizado */
        .navbar-toggler {
            border: 2px solid var(--dirty-gold);
            border-radius: 0;
            padding: 8px 12px;
        }
        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23d4a017' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Dropdown menu para produtos */
        .dropdown-menu-grunge {
            background: #1a1613;
            border: 1px solid var(--rust-red);
            border-radius: 0;
            margin-top: 8px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
        }
        .dropdown-menu-grunge .dropdown-item {
            color: var(--chalk-white);
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 1px;
            padding: 10px 20px;
            transition: 0.1s;
        }
        .dropdown-menu-grunge .dropdown-item:hover {
            background: var(--rust-red);
            color: var(--dirty-gold);
        }
        .dropdown-divider {
            border-top: 1px solid var(--rust-red);
            opacity: 0.3;
        }

        /* Dropdown do usuário */
        .user-dropdown {
            background: #1a1613;
            border: 1px solid var(--dirty-gold);
            border-radius: 0;
            width: 200px;
        }
        .user-dropdown .dropdown-item {
            color: var(--chalk-white);
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 10px 20px;
        }
        .user-dropdown .dropdown-item:hover {
            background: var(--rust-red);
            color: var(--dirty-gold);
        }
        .user-dropdown .dropdown-item i {
            margin-right: 10px;
            width: 20px;
        }
        .user-avatar {
            width: 35px;
            height: 35px;
            background: var(--rust-red);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
        }
        .user-avatar i {
            font-size: 1.2rem;
            color: var(--dirty-gold);
        }

        /* Botões e elementos gerais */
        .btn-rock {
            background: var(--rust-red);
            border: none;
            font-weight: 800;
            letter-spacing: 1.5px;
            padding: 10px 28px;
            transition: 0.2s;
            color: white;
            text-transform: uppercase;
            clip-path: polygon(0% 0%, 95% 0%, 100% 30%, 100% 70%, 95% 100%, 0% 100%, 0% 70%, 3% 30%);
        }
        .btn-rock:hover {
            background: var(--dirty-gold);
            color: #0a0a0a;
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(180,43,43,0.5);
        }
        .btn-outline-rock {
            background: transparent;
            border: 2px solid var(--dirty-gold);
            color: var(--dirty-gold);
            font-weight: 800;
            transition: 0.2s;
        }
        .btn-outline-rock:hover {
            background: var(--dirty-gold);
            color: black;
            box-shadow: 0 0 12px #d4a017;
        }

        /* CARDS COM ESTILO DESGASTADO (global) */
        .card-grunge {
            background: #1c1814e0;
            backdrop-filter: blur(2px);
            border: 1px solid #4a3d34;
            border-radius: 0px;
            transition: all 0.3s ease;
            overflow: hidden;
            box-shadow: 5px 5px 0px rgba(0,0,0,0.5);
        }
        .card-grunge:hover {
            transform: translateY(-8px);
            border-color: var(--dirty-gold);
            box-shadow: 12px 12px 0px #2a1f1a;
        }

        /* Footer */
        footer {
            background: #070503;
            border-top: 5px double var(--dirty-gold);
            margin-top: 60px;
        }

        /* scroll personalizado */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #1a1512; }
        ::-webkit-scrollbar-thumb { background: var(--rust-red); border-radius: 0; }

        /* animações globais */
        @keyframes flicker {
            0% { opacity: 0.9; text-shadow: 0 0 2px red;}
            100% { opacity: 1; text-shadow: 0 0 8px gold;}
        }
        .rock-flicker {
            animation: flicker 1.8s infinite alternate;
        }

        /* responsividade */
        @media (max-width: 768px) {
            .navbar-brand { font-size: 1.4rem; }
            .nav-link { font-size: 0.75rem; margin: 5px 0; }
            .user-avatar { width: 28px; height: 28px; }
            .user-avatar i { font-size: 0.9rem; }
        }
    </style>

    @stack('styles')
</head>
<body class="default-bg">

<!-- LATERAIS COM IMAGENS GRUNGE/ROCK -->
<div class="side-grunge left"></div>
<div class="side-grunge right"></div>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-grunge sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-vinyl-fill me-2"></i> BARGANHA
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <!-- Produtos com dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-grid-3x3-gap-fill me-1"></i> PRODUTOS
                    </a>
                    <ul class="dropdown-menu dropdown-menu-grunge">
                        <li><a class="dropdown-item" href="{{ route('home', ['tipo_midia' => 'Música']) }}" data-tipo="musica"><i class="bi bi-vinyl-fill me-2"></i> 🎵 MÚSICA</a></li>
                        <li><a class="dropdown-item" href="{{ route('home', ['tipo_midia' => 'Filme']) }}" data-tipo="filme"><i class="bi bi-film me-2"></i> 🎬 FILMES</a></li>
                        <li><a class="dropdown-item" href="{{ route('home', ['tipo_midia' => 'Jogo']) }}" data-tipo="jogo"><i class="bi bi-controller me-2"></i> 🎮 GAMES</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('categories.index') }}"><i class="bi bi-tags me-2"></i> TODAS CATEGORIAS</a></li>
                    </ul>
                </li>
                
                <!-- ESTOQUE VISÍVEL PARA TODOS -->
                <li class="nav-item"><a class="nav-link text-warning" href="{{ route('items.index') }}"><i class="bi bi-database-gear me-1"></i> ESTOQUE</a></li>
                
                <!-- COMUNIDADES -->
                <li class="nav-item"><a class="nav-link text-info" href="{{ route('communities.index') }}"><i class="bi bi-people-fill me-1"></i> COMUNIDADES</a></li>
                
                @auth
                    <!-- INTERESSES -->
                    <li class="nav-item"><a class="nav-link text-danger" href="{{ route('interests.index') }}"><i class="bi bi-heart-fill me-1"></i> INTERESSES</a></li>
                    
                    <!-- DROPDOWN DO USUÁRIO (Perfil, Avaliações, Sair) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <span class="d-none d-lg-inline">{{ Str::limit(auth()->user()->name, 15) }}</span>
                        </a>
                        <ul class="dropdown-menu user-dropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('communities.profile', auth()->user()) }}">
                                    @if(auth()->user()->image)
                                        <img src="{{ asset('storage/' . auth()->user()->image) }}" 
                                            alt="Perfil" 
                                            class="rounded-circle me-2" 
                                            style="width: 24px; height: 24px; object-fit: cover; border: 1px solid var(--dirty-gold);">
                                    @else
                                        <i class="bi bi-person-badge me-2"></i>
                                    @endif
                                    <span>MEU PERFIL</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> SAIR
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link border border-secondary rounded-0 px-3" href="{{ route('login') }}"><i class="bi bi-person-fill me-1"></i> ENTRAR</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main>
    <div class="container-fluid px-4 px-lg-5">
        @if(session('success'))
            <div class="alert alert-grunge fade show d-flex align-items-center justify-content-between mt-3" role="alert">
                <div><i class="bi bi-check-circle-fill me-2 fs-5 text-warning"></i> {{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert fade show d-flex align-items-center justify-content-between mt-3" role="alert" style="background: #8b1e1e; border-left: 5px solid #d4a017;">
                <div><i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i> {{ session('error') }}</div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<footer class="text-center py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 mb-3">
                <i class="bi bi-disc-fill fs-2 text-warning rock-flicker"></i>
                <p class="small mt-2 text-secondary">+ de 800 itens da podreira underground</p>
            </div>
            <div class="col-md-4 mb-3">
                <i class="bi bi-people-fill fs-2 text-danger"></i>
                <p class="small mt-2 text-secondary">Comunidade Grunge & Rock</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="text-secondary"><i class="bi bi-instagram fs-5"></i></a>
                    <a href="#" class="text-secondary"><i class="bi bi-discord fs-5"></i></a>
                    <a href="#" class="text-secondary"><i class="bi bi-spotify fs-5"></i></a>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <i class="bi bi-shield-shaded fs-2 text-warning"></i>
                <p class="small mt-2 text-secondary">Selo de autenticidade CAÓTICA</p>
            </div>
        </div>
        <div class="border-top border-secondary pt-4 mt-3">
            <p class="mb-0 small text-muted text-uppercase">
                <i class="bi bi-lightning-charge-fill text-warning"></i> BARGANHA © 2026 – ONDE O RARO ENCONTRA O CAOS <i class="bi bi-lightning-charge-fill text-warning"></i>
            </p>
            <p class="small text-muted mt-2">Underground Collection • Música, Cinema, Games & Atitude Suja</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ========== FUNDO DINÂMICO BASEADO NO TIPO DE MÍDIA ==========
    function setBackgroundByTipoMidia() {
        const urlParams = new URLSearchParams(window.location.search);
        const tipoMidia = urlParams.get('tipo_midia');
        const body = document.body;
        
        // Remove classes existentes
        body.classList.remove('musica-bg', 'filme-bg', 'jogo-bg', 'default-bg');
        
        // Adiciona a classe correspondente
        if (tipoMidia === 'Música') {
            body.classList.add('musica-bg');
        } else if (tipoMidia === 'Filme') {
            body.classList.add('filme-bg');
        } else if (tipoMidia === 'Jogo') {
            body.classList.add('jogo-bg');
        } else {
            body.classList.add('default-bg');
        }
    }
    
    // Executa ao carregar a página
    setBackgroundByTipoMidia();
    
    // Também observa mudanças de navegação (para links internos com turbo/hotwire)
    document.addEventListener('DOMContentLoaded', setBackgroundByTipoMidia);
    
    // Para navegação com livewire/turbo (se usar)
    if (typeof Livewire !== 'undefined') {
        Livewire.hook('message.processed', () => setBackgroundByTipoMidia());
    }
    
    // Efeito nos botões
    document.querySelectorAll('.btn-rock, .btn-outline-rock').forEach(btn => {
        btn.addEventListener('click', (e) => {
            if(!btn.closest('form')) e.preventDefault();
            if(btn.innerText.includes('BARGANHA') || btn.innerText.includes('GARIMPAR') || btn.innerText.includes('INTERESSE')) {
                const original = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check-lg"></i> CAOS ENGATILHADO!';
                setTimeout(() => { btn.innerHTML = original; }, 1800);
            } else if(!btn.closest('form')) {
                btn.style.transform = 'scale(0.97)';
                setTimeout(() => btn.style.transform = '', 150);
            }
        });
    });
    
    console.log("%c🔥 UNDERGROUND MODE ATIVADO - GRUNGE E ROCK 🔥", "color: #d4a017; font-size: 18px; font-weight: bold;");
</script>

@stack('scripts')
</body>
</html>