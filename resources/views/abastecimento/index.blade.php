@extends('adminlte::page')

@section('title', 'Gerenciamento de Abastecimentos')

@section('content_header')
    <h1>Gerenciamento de Abastecimentos</h1>
    <hr>
@stop

@section('content')

<div class="mb-3 d-flex justify-content-">
    <form method="get" id="limitForm">
        <label for="limitSelect" class="me-2">Itens por página:</label>
        <select name="limit" id="limitSelect" class="form-select d-inline w-auto"
                onchange="document.getElementById('limitForm').submit();">
            <option value="10" {{ request('limit', $limit) == 10 ? 'selected' : '' }}>10</option>
            <option value="25" {{ request('limit', $limit) == 25 ? 'selected' : '' }}>25</option>
            <option value="50" {{ request('limit', $limit) == 50 ? 'selected' : '' }}>50</option>
            <option value="100" {{ request('limit', $limit) == 100 ? 'selected' : '' }}>100</option>
        </select>
        <input type="hidden" name="page" value="{{ $currentPage }}">
    </form>
</div>


<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Data de abastecimento</th>
                <th>Veiculo</th>
                <th>Motorista</th>
                <th>Posto</th>
                <th>Tipo de Combustivel</th>
                <th>KM Atual</th>
                <th>Média KM/L</th>
                <th>Litros</th>
                <th>Preço do litro</th>
                <th>Valor Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($abastecimentos ?? [] as $abastecimento)
                <tr>
                    <td>{{ $abastecimento['id'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($abastecimento['data_abastecimento'])->format('d/m/Y H:i') }}</td>
                    <td>{{ $abastecimento['veiculo']['placa'] }}</td>
                    <td>{{ $abastecimento['motorista']['nome'] }}</td>
                    <td>{{ $abastecimento['posto']['nome'] }}</td>
                    <td>{{ $abastecimento['tipo_combustivel'] }}</td>
                    <td>{{ $abastecimento['km_atual'] }}</td>
                    <td>{{ $abastecimento['media_km_litro'] }}</td>
                    <td>{{ number_format(($abastecimento['valor']/$abastecimento['preco_combustivel']), 3, '.') }}</td>
                    <td>R$ {{ number_format($abastecimento['preco_combustivel'], 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($abastecimento['valor'], 2, ',', '.') }}</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#editAbastecimentoModal{{ $abastecimento['id'] }}">
                            ✏️
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteAbastecimentoModal{{ $abastecimento['id'] }}">
                            🗑️
                        </button>
                    </td>
                </tr>

                @include('abastecimento.modals.edit', ['abastecimento' => $abastecimento])
                @include('abastecimento.modals.delete', ['abastecimento' => $abastecimento])
            @endforeach
        </tbody>
    </table>
</div>

<!-- Paginação -->

<nav>
    <ul class="pagination justify-content-center">
        <!-- Botões Primeira e Anterior -->
        <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
            <a class="page-link" href="?page=1">Primeira</a>
        </li>
        <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
            <a class="page-link" href="?page={{ max(1, $currentPage - 1) }}">Anterior</a>
        </li>

        <!-- Números de página com ellipses -->
        @if ($currentPage > 3)
            <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
            <li class="page-item disabled"><span class="page-link">...</span></li>
        @endif

        @for ($i = max(1, $currentPage - 2); $i <= min($lastPage, $currentPage + 2); $i++)
            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
            </li>
        @endfor

        @if ($currentPage < $lastPage - 2)
            <li class="page-item disabled"><span class="page-link">...</span></li>
            <li class="page-item"><a class="page-link" href="?page={{ $lastPage }}">{{ $lastPage }}</a></li>
        @endif

        <!-- Botões Próxima e Última -->
        <li class="page-item {{ $currentPage == $lastPage }}">
            <a class="page-link" href="?page={{ min($lastPage, $currentPage + 1) }}">Próxima</a>
        </li>
        <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
            <a class="page-link" href="?page={{ $lastPage }}">Última</a>
        </li>
    </ul>
</nav>
@stop

@section('css')
<link
href="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-2.0.3/af-2.7.0/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/cr-2.0.0/fc-5.0.0/fh-4.0.1/kt-2.12.0/r-3.0.1/sc-2.4.1/sb-1.7.0/sp-2.3.0/datatables.min.css"
rel="stylesheet">

<style>
    table th,
   table td {
       padding: 1px;
       text-align: center;
   }
   table {
       border-collapse: separate;
       border-spacing: 0;
       width: 100%;
       font-size: 14px;
       color: #333;
       background-color: #fff;
   }

   table thead {
       background-color: var(--blue-1) !important;
   }

   table thead th {
       padding: 10px;
       font-weight: 600;
       border-bottom: 2px solid #dee2e6;
       text-transform: uppercase;
       font-size: 12px;
       color: #f5f5f5;
   }

   table tbody td {
       padding: 10px;
       border-bottom: 1px solid #dee2e6;
       vertical-align: middle;
   }

   table tbody tr:nth-child(odd) {
       background-color: #fdfdfd;
   }

   table tbody tr:nth-child(even) {
       background-color: #f6f6f6;
   }

   table tfoot td {
       font-weight: bold;
       padding: 10px;
       background-color: #f8f9fa;
       border-top: 2px solid #dee2e6;
   }
   </style>
@stop

@section('js')
<script
src="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-2.0.3/af-2.7.0/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/cr-2.0.0/fc-5.0.0/fh-4.0.1/kt-2.12.0/r-3.0.1/sc-2.4.1/sb-1.7.0/sp-2.3.0/datatables.min.js">
</script>
@stop
