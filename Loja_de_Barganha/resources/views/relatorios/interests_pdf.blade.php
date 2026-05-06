<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Interesses</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #dc3545; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { color: #dc3545; text-transform: uppercase; margin: 0; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #f8f9fa; color: #dc3545; text-align: left; padding: 10px; border-bottom: 1px solid #ddd; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        .status { font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 10px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Relatório de Interesses - Informatics & Zoo</h2>
        <p>Gerado em: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Item</th>
                <th>Usuário/IP</th>
                <th>Status</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($interests as $interest)
                <tr>
                    <td>{{ $interest->created_at->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $interest->item->titulo }}</strong><br>
                        <small>{{ $interest->item->artista_diretor }}</small>
                    </td>
                    <td>
                        {{ $interest->user->name ?? 'Visitante' }}<br>
                        <small>{{ $interest->ip_address }}</small>
                    </td>
                    <td class="status">{{ $interest->status }}</td>
                    <td>R$ {{ number_format($interest->item->preco, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Página gerada pelo sistema de gestão de leads.
    </div>
</body>
</html>