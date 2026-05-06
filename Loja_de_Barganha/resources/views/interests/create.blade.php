@extends('layouts.app')

@section('title', 'Manifestar Interesse - ' . $item->titulo)

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark border-secondary">
                <div class="card-header bg-black border-warning">
                    <h4 class="text-warning mb-0">
                        <i class="bi bi-heart-fill me-2"></i> Manifestar Interesse
                    </h4>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <h5 class="text-white">{{ $item->titulo }}</h5>
                        @if($item->artista_diretor)
                            <p class="text-muted">{{ $item->artista_diretor }}</p>
                        @endif
                        <p class="text-warning">R$ {{ number_format($item->preco, 2, ',', '.') }}</p>
                    </div>

                    <form action="{{ route('interests.store', $item) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label text-warning">📅 Data de retirada <span class="text-muted">(opcional)</span></label>
                            <input type="date" name="data_retirada" 
                                   class="form-control bg-dark text-white border-secondary" 
                                   value="{{ old('data_retirada') }}">
                            <small class="text-muted">Quando você pretende retirar/negociar?</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-warning">📅 Data de devolução <span class="text-muted">(opcional)</span></label>
                            <input type="date" name="data_devolucao" 
                                   class="form-control bg-dark text-white border-secondary" 
                                   value="{{ old('data_devolucao') }}">
                            <small class="text-muted">Se for um aluguel, informe a previsão de devolução.</small>
                        </div>

                        <div class="d-flex justify-content-between gap-3">
                            <a href="{{ route('items.show', $item) }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-x-lg"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-heart"></i> Confirmar Interesse
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 text-center">
                <small class="text-muted">
                    <i class="bi bi-info-circle"></i> Ao registrar, você concorda em receber contato do vendedor.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection