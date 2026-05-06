@extends('layouts.app')

@section('title', 'Cadastrar Nova Relíquia')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('items.index') }}" class="btn-outline-rock">
                    <i class="bi bi-arrow-left"></i> VOLTAR
                </a>
                <div class="blink-caos"></div>
                <h1 class="display-5 fw-black text-uppercase m-0" style="font-family: 'Special Elite', cursive;">
                    <i class="bi bi-plus-circle-fill text-warning me-2"></i>NOVA RELÍQUIA
                </h1>
            </div>

            <div class="card-grunge p-4">
                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- COLUNA ESQUERDA -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-uppercase fw-bold small">TÍTULO <span class="text-danger">*</span></label>
                                <input type="text" name="titulo" class="form-control bg-dark text-white border-secondary @error('titulo') is-invalid @enderror" value="{{ old('titulo') }}" required>
                                @error('titulo') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-uppercase fw-bold small">ARTISTA / DIRETOR</label>
                                <input type="text" name="artista_diretor" class="form-control bg-dark text-white border-secondary" value="{{ old('artista_diretor') }}">
                                <small class="text-dim">Banda, artista, diretor ou estúdio</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-uppercase fw-bold small">EMPRESA PRODUTORA</label>
                                <input type="text" name="empresa_produtora" class="form-control bg-dark text-white border-secondary" value="{{ old('empresa_produtora') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-uppercase fw-bold small">ELENCO / DETALHES</label>
                                <textarea name="elenco_detalhes" class="form-control bg-dark text-white border-secondary" rows="3">{{ old('elenco_detalhes') }}</textarea>
                                <small class="text-dim">Para filmes: atores principais. Para jogos: plataformas.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-uppercase fw-bold small">DESCRIÇÃO</label>
                                <textarea name="descricao" class="form-control bg-dark text-white border-secondary" rows="3">{{ old('descricao') }}</textarea>
                                <small class="text-dim">Nota do garimpeiro sobre o item</small>
                            </div>
                        </div>

                        <!-- COLUNA DIREITA -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-uppercase fw-bold small">PREÇO (R$) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="preco" class="form-control bg-dark text-white border-secondary @error('preco') is-invalid @enderror" value="{{ old('preco') }}" required>
                                @error('preco') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-uppercase fw-bold small">QUANTIDADE EM ESTOQUE</label>
                                <input type="number" name="quantidade_estoque" class="form-control bg-dark text-white border-secondary" value="{{ old('quantidade_estoque', 1) }}" min="0">
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-uppercase fw-bold small">CATEGORIA <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select bg-dark text-white border-secondary @error('category_id') is-invalid @enderror" required>
                                    <option value="">Selecione...</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->nome }} ({{ $cat->tipo_midia }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-uppercase fw-bold small">FORMATO DE MÍDIA <span class="text-danger">*</span></label>
                                <select name="media_format_id" class="form-select bg-dark text-white border-secondary @error('media_format_id') is-invalid @enderror" required>
                                    <option value="">Selecione...</option>
                                    @foreach($formats as $fmt)
                                        <option value="{{ $fmt->id }}" {{ old('media_format_id') == $fmt->id ? 'selected' : '' }}>
                                            {{ $fmt->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('media_format_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-uppercase fw-bold small">CAPA DO ITEM</label>
                                <input type="file" name="capa" class="form-control bg-dark text-white border-secondary" accept="image/*">
                                <small class="text-dim">JPG, PNG até 2MB</small>
                                @error('capa') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <!-- SEÇÃO: FICHA DE CONSERVAÇÃO (agora sem estado_geral) -->
                        <div class="col-12 mt-3">
                            <div class="border-top border-warning pt-3 mb-3">
                                <h5 class="text-warning text-uppercase fw-bold small mb-3">
                                    <i class="bi bi-shield-shaded me-2"></i>FICHA DE CONSERVAÇÃO
                                </h5>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label text-uppercase fw-bold small">ESTADO DA CAIXA</label>
                                    <select name="estado_caixa" class="form-select bg-dark text-white border-secondary">
                                        <option value="Perfeita" {{ old('estado_caixa') == 'Perfeita' ? 'selected' : '' }}>Perfeita</option>
                                        <option value="Com marcas de uso" {{ old('estado_caixa') == 'Com marcas de uso' ? 'selected' : '' }}>Com marcas de uso</option>
                                        <option value="Danificada" {{ old('estado_caixa') == 'Danificada' ? 'selected' : '' }}>Danificada</option>
                                        <option value="Sem caixa" {{ old('estado_caixa') == 'Sem caixa' ? 'selected' : '' }}>Sem caixa</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-uppercase fw-bold small">ESTADO DA MÍDIA</label>
                                    <select name="estado_midia" class="form-select bg-dark text-white border-secondary">
                                        <option value="Perfeita" {{ old('estado_midia') == 'Perfeita' ? 'selected' : '' }}>Perfeita</option>
                                        <option value="Riscos leves" {{ old('estado_midia') == 'Riscos leves' ? 'selected' : '' }}>Riscos leves</option>
                                        <option value="Riscos profundos" {{ old('estado_midia') == 'Riscos profundos' ? 'selected' : '' }}>Riscos profundos</option>
                                        <option value="Mofada" {{ old('estado_midia') == 'Mofada' ? 'selected' : '' }}>Mofada</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-uppercase fw-bold small d-block">&nbsp;</label>
                                    <div class="form-check">
                                        <input type="checkbox" name="possui_manual" class="form-check-input" id="possui_manual" value="1" {{ old('possui_manual') ? 'checked' : '' }}>
                                        <label class="form-check-label text-white" for="possui_manual">Possui Manual / Encarte</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label text-uppercase fw-bold small">DETALHES DO TESTE</label>
                                <textarea name="detalhes_teste" class="form-control bg-dark text-white border-secondary" rows="2" placeholder="Ex: Disco testado, sem pulos. Caixa com leves marcas de uso.">{{ old('detalhes_teste') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 justify-content-end mt-5 pt-3 border-top border-secondary">
                        <a href="{{ route('items.index') }}" class="btn-outline-rock px-4">CANCELAR</a>
                        <button type="submit" class="btn-rock px-5">
                            <i class="bi bi-save me-2"></i> CADASTRAR RELÍQUIA
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .card-grunge {
        background: #111;
        border: 1px solid #2a2a2a;
        padding: 30px;
    }
    .blink-caos {
        width: 12px;
        height: 12px;
        background: var(--dirty-gold);
        animation: blink 1s infinite;
    }
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }
    .form-control:focus, .form-select:focus {
        background-color: #1a1a1a;
        border-color: var(--dirty-gold);
        box-shadow: none;
    }
    .btn-outline-rock {
        background: transparent;
        border: 2px solid var(--dirty-gold);
        color: var(--dirty-gold);
        padding: 8px 20px;
        text-transform: uppercase;
        font-weight: bold;
        transition: 0.2s;
    }
    .btn-outline-rock:hover {
        background: var(--dirty-gold);
        color: black;
        text-decoration: none;
    }
    .btn-rock {
        background: var(--rust-red);
        border: none;
        color: white;
        padding: 8px 20px;
        text-transform: uppercase;
        font-weight: bold;
        transition: 0.2s;
    }
    .btn-rock:hover {
        background: var(--dirty-gold);
        color: black;
    }
</style>
@endsection