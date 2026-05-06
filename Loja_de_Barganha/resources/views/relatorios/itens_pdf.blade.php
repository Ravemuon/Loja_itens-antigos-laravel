<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Estoque Underground</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            background: #0c0b0a;
            color: #e0d6c0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #b85c1a;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #d4a017;
            margin: 0;
        }
        .header p {
            font-size: 12px;
            color: #aaa;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        th {
            background: #1a1614;
            color: #d4a017;
            text-transform: uppercase;
            padding: 8px 4px;
            border-bottom: 2px solid #b85c1a;
            text-align: left;
        }
        td {
            padding: 6px 4px;
            border-bottom: 1px solid #333;
        }
        .price {
            text-align: right;
            font-weight: bold;
            color: #d4a017;
        }
        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 9px;
            color: #777;
            border-top: 1px dashed #444;
            padding-top: 10px;
        }
        .badge-category {
            background: #2a241f;
            padding: 2px 5px;
            font-size: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📀 ARQUIVO UNDERGROUND – RELATÓRIO DE ESTOQUE</h1>
        <p>Gerado em {{ $generated_at }} | Total de itens: {{ $total_items }}</p>
        @if($search)
            <p>🔍 Filtro: "{{ $search }}"</p>
        @endif
        @if($tipoMidia)
            <p>💿 Mídia: {{ $tipoMidia }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título / Produtor</th>
                <th>Seção</th>
                <th>Mídia</th>
                <th>Formato</th>
                <th class="price">Preço (R$)</th>
                <th>Estoque</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        <strong>{{ $item->titulo }}</strong><br>
                        <small>{{ $item->artista_diretor ?? $item->empresa_produtora }}</small>
                    </td>
                    <td><span class="badge-category">{{ $item->category->nome ?? '—' }}</span></td>
                    <td>{{ $item->tipo_midia }}</td>
                    <td>{{ $item->mediaFormat->nome ?? '—' }}</td>
                    <td class="price">R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
                    <td class="text-center">{{ $item->quantidade_estoque }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Nenhum item encontrado com os filtros aplicados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        ARQUIVO MORTO — EDIÇÃO {{ date('Y') }} • Sistema de Bargaha Underground
    </div>
</body>
</html>