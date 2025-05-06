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
            @forelse ($abastecimentos as $chave => $abastecimento)
                <tr>
                    <td>{{ $abastecimento['data_abastecimento'] ? \Carbon\Carbon::parse($abastecimento['data_abastecimento'])->format('d/m/Y') : '' }}</td>
                    <td>{{ $abastecimento['veiculo'] ? $abastecimento['veiculo']['placa'] : '' }}</td>
                    <td>{{ $abastecimento['motorista'] ? $abastecimento['motorista']['nome'] : '' }}</td>
                    <td>{{ $abastecimento['tipo_combustivel'] ? $abastecimento['tipo_combustivel'] : '' }}</td>
                    <td>{{ $abastecimento['valor'] && $abastecimento['preco_combustivel'] ? number_format($abastecimento['valor']/$abastecimento['preco_combustivel'], 3) : '' }}L</td>
                    <td>R${{ $abastecimento['valor']  ? $abastecimento['valor'] : '' }} </td>
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
