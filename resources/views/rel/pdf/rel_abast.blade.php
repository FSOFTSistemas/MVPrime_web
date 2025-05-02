<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Abastecimentos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Relatório de Abastecimentos</h2>

    <p><strong>Filtros Aplicados:</strong></p>
    <ul>
        @foreach ($filtros as $chave => $valor)
            @if (!empty($valor))
                <li><strong>{{ ucfirst(str_replace('_', ' ', $chave)) }}:</strong> {{ $valor }}</li>
            @endif
        @endforeach
    </ul>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Placa</th>
                <th>Motorista</th>
                <th>Tipo Combustível</th>
                <th>Quantidade</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($abastecimentos as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->data)->format('d/m/Y') }}</td>
                    <td>{{ $item->placa }}</td>
                    <td>{{ $item->motorista }}</td>
                    <td>{{ $item->tipo_combustivel }}</td>
                    <td>{{ $item->quantidade }} L</td>
                    <td>R$ {{ number_format($item->valor, 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Nenhum registro encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
