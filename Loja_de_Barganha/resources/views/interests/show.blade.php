@extends('layouts.app')

@section('title', 'Detalhes do Interesse')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-white">
                <i class="bi bi-info-circle-fill text-danger me-2"></i> 
                DETALHES DO INTERESSE
            </h2>
            <p class="text-dim mb-0 small border-start border-danger border-3 ps-3">
                Informações completas sobre a negociação e o item desejado
            </p>
        </div>
        <a href="{{ route('interests.index') }}" class="btn-outline-rock">
            <i class="bi bi-arrow-left-circle"></i> VOLTAR
        </a>
    </div>

    <div class="row g-4">
        {{-- CARD: ITEM RELACIONADO --}}
        <div class="col-md-6">
            <div class="card bg-dark border-secondary h-100 shadow">
                <div class="card-header bg-black border-danger bg-opacity-25">
                    <h5 class="text-danger mb-0">
                        <i class="bi bi-vinyl-fill me-1"></i> ITEM
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        @if($interest->item->capa)
                            <img src="{{ asset('storage/' . $interest->item->capa) }}" 
                                 class="rounded border border-secondary" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="bg-black rounded border border-secondary d-flex align-items-center justify-content-center" 
                                 style="width: 100px; height: 100px;">
                                <i class="bi bi-vinyl text-dim fs-1"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <h4 class="text-white mb-1">{{ $interest->item->titulo }}</h4>
                            <p class="text-danger mb-2">{{ $interest->item->artista_diretor }}</p>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-dark text-white border border-secondary">
                                    <i class="bi bi-tag"></i> {{ $interest->item->category->nome ?? 'Sem categoria' }}
                                </span>
                                <span class="badge bg-dark text-white border border-secondary">
                                    <i class="bi bi-disc"></i> {{ $interest->item->mediaFormat->nome ?? 'Formato não definido' }}
                                </span>
                                @if($interest->item->ano)
                                <span class="badge bg-dark text-white border border-secondary">
                                    <i class="bi bi-calendar"></i> {{ $interest->item->ano }}
                                </span>
                                @endif
                            </div>
                            <div class="price-tag text-warning fs-4 fw-bold">
                                R$ {{ number_format($interest->item->preco, 2, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 text-end">
                        <a href="{{ route('items.show', $interest->item->id) }}" class="btn btn-sm btn-outline-info" target="_blank">
                            <i class="bi bi-box-arrow-up-right"></i> VER NA VITRINE
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD: NEGOCIAÇÃO --}}
        <div class="col-md-6">
            <div class="card bg-dark border-secondary h-100 shadow">
                <div class="card-header bg-black border-warning bg-opacity-25">
                    <h5 class="text-warning mb-0">
                        <i class="bi bi-calculator-fill me-1"></i> NEGOCIAÇÃO
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 pb-2 border-bottom border-secondary">
                            <i class="bi bi-trophy-fill text-warning me-2"></i>
                            <strong class="text-dim">Status atual:</strong>
                            @php
                                $statusConfig = [
                                    'pendente' => ['bg' => 'bg-danger-soft', 'text' => 'text-danger', 'icon' => 'clock-history', 'label' => 'PENDENTE'],
                                    'alugado' => ['bg' => 'bg-warning-soft', 'text' => 'text-warning', 'icon' => 'check-circle', 'label' => 'ALUGADO'],
                                    'devolvido' => ['bg' => 'bg-success-soft', 'text' => 'text-success', 'icon' => 'arrow-return-left', 'label' => 'DEVOLVIDO'],
                                    'cancelado' => ['bg' => 'bg-secondary-soft', 'text' => 'text-muted', 'icon' => 'x-circle', 'label' => 'CANCELADO'],
                                ];
                                $cfg = $statusConfig[$interest->status] ?? $statusConfig['pendente'];
                            @endphp
                            <span class="badge {{ $cfg['bg'] }} {{ $cfg['text'] }} border px-3 py-2 ms-2">
                                <i class="bi bi-{{ $cfg['icon'] }}"></i> {{ $cfg['label'] }}
                            </span>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-calendar-check text-success me-2"></i>
                            <strong class="text-dim">Data de retirada:</strong>
                            <span class="text-white float-end">
                                {{ $interest->data_retirada ? \Carbon\Carbon::parse($interest->data_retirada)->format('d/m/Y') : '—' }}
                            </span>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-calendar-x text-danger me-2"></i>
                            <strong class="text-dim">Data de devolução:</strong>
                            <span class="text-white float-end">
                                {{ $interest->data_devolucao ? \Carbon\Carbon::parse($interest->data_devolucao)->format('d/m/Y') : '—' }}
                            </span>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-hourglass-split text-info me-2"></i>
                            <strong class="text-dim">Criado há:</strong>
                            <span class="text-white float-end">{{ $interest->created_at->diffForHumans() }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- CARD: INTERESSADO (com informações de contato e ações) --}}
        <div class="col-12">
            <div class="card bg-dark border-secondary shadow">
                <div class="card-header bg-black border-info bg-opacity-25">
                    <h5 class="text-info mb-0">
                        <i class="bi bi-person-badge me-1"></i> INTERESSADO
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless text-white">
                                <tr>
                                    <td style="width: 130px"><i class="bi bi-person-circle text-info"></i> <strong>Nome:</strong></td>
                                    <td>{{ $interest->user->name ?? 'Visitante' }}</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-envelope text-info"></i> <strong>E-mail:</strong></td>
                                    <td>{{ $interest->user->email ?? 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-telephone text-info"></i> <strong>Telefone:</strong></td>
                                    <td>{{ $interest->user->phone ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-geo-alt text-info"></i> <strong>IP de origem:</strong></td>
                                    <td><code>{{ $interest->ip_address ?? '—' }}</code></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            @php
                                $whatsMsg = "Olá! Estou respondendo seu interesse pelo item: " . $interest->item->titulo;
                                $whatsPhone = $interest->user->phone ?? '';
                                $whatsLink = $whatsPhone ? 'https://wa.me/' . preg_replace('/\D/', '', $whatsPhone) . '?text=' . urlencode($whatsMsg) : '#';
                            @endphp
                            @if(auth()->user()->is_admin && $whatsPhone)
                                <div class="d-grid gap-2">
                                    <a href="{{ $whatsLink }}" target="_blank" class="btn btn-success">
                                        <i class="bi bi-whatsapp"></i> ENTRAR EM CONTATO VIA WHATSAPP
                                    </a>
                                    <small class="text-dim text-center">Clique para conversar diretamente com o interessado</small>
                                </div>
                            @else
                                <div class="alert alert-secondary bg-black-50 text-dim mb-0 small">
                                    <i class="bi bi-info-circle"></i> Telefone disponível apenas para administradores.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- AÇÕES FINAIS --}}
    <div class="mt-4 d-flex flex-wrap gap-3 justify-content-end">
        <a href="{{ route('interests.edit', $interest->id) }}" class="btn btn-warning btn-lg">
            <i class="bi bi-pencil-square"></i> EDITAR INTERESSE
        </a>
        <form action="{{ route('interests.destroy', $interest->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-lg" onclick="return confirm('Tem certeza que deseja cancelar este interesse?')">
                <i class="bi bi-trash3"></i> CANCELAR NEGOCIAÇÃO
            </button>
        </form>
    </div>
</div>

<style>
    .price-tag {
        font-family: 'JetBrains Mono', monospace;
        letter-spacing: -0.5px;
    }
    .btn-outline-rock {
        background: transparent;
        border: 2px solid #ffc107;
        color: #ffc107;
        padding: 6px 20px;
        text-decoration: none;
        border-radius: 40px;
        transition: 0.2s;
    }
    .btn-outline-rock:hover {
        background: #ffc107;
        color: black;
    }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.2); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.2); }
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.2); }
    .bg-secondary-soft { background-color: rgba(108, 117, 125, 0.2); }
    .table-borderless td, .table-borderless th {
        border: none;
        padding: 0.5rem 0;
    }
    .card-header {
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
</style>
@endsection