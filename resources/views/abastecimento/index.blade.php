@extends('adminlte::page')

@section('title', 'Gerenciamento de Abastecimentos')

@section('content_header')
    <h1>Gerenciamento de Abastecimentos</h1>
    <hr>
@stop

@section('content')

    <div class="mb-3 d-flex justify-content-">
        <form method="get" id="limitForm">
            <label for="limitSelect" class="me-2" style="color:var(--blue-2)">Itens por página:</label>
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


        <table id="abastecimentoTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data de abastecimento</th>
                    <th>Veiculo</th>
                    <th>Motorista</th>
                    <th>Posto</th>
                    <th>Secretaria</th>
                    <th>Tipo de Combustivel</th>
                    <th>KM Atual</th>
                    <th>Média KM/L</th>
                    <th>Litros</th>
                    <th>Preço do litro</th>
                    <th>Valor Total</th>
                    @can('gerenciar_usuarios')
                        <th>Ações</th>
                    @endcan

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
                        <td>{{ $abastecimento['secretaria']['nome'] ?? '--' }}</td>
                        <td>{{ $abastecimento['tipo_combustivel'] }}</td>
                        <td>{{ $abastecimento['km_atual'] }}</td>
                        <td>{{ $abastecimento['media_km_litro'] }}</td>
                        <td>{{ number_format($abastecimento['valor'] / $abastecimento['preco_combustivel'], 3, '.') }}</td>
                        <td>R$ {{ number_format($abastecimento['preco_combustivel'], 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($abastecimento['valor'], 2, ',', '.') }}</td>
                        @can('gerenciar_usuarios')
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                    data-target="#editAbastecimentoModal{{ $abastecimento['id'] }}">
                                    ✏️
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#deleteAbastecimentoModal{{ $abastecimento['id'] }}">
                                    🗑️
                                </button>
                            </td>
                        @endcan
                    </tr>

                    @include('abastecimento.modals.edit', ['abastecimento' => $abastecimento])
                    @include('abastecimento.modals.delete', ['abastecimento' => $abastecimento])
                @endforeach
            </tbody>
        </table>

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
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

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
        .dataTables_wrapper {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 5px;
            font-size: 14px;
            color: #495057;
        }

        .dt-buttons .dt-button {
            border-radius: 4px !important;
            border: none !important;
            background-color: #fff !important;
            color: var(--blue-1) !important;
            margin-left: 5px !important;
            padding: 5px 10px;
            transition: 0.5s;
        }

        .dt-buttons .dt-button:hover {
            color: var(--blue-2) !important;
            transition: all 0.5s;
        }
        .dt-search label, .dt-search input {
            color: var(--blue-2) !important;
        }
        .dt-paging , .dt-info{
            display: none;
        }
    </style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script
        src="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-2.0.3/af-2.7.0/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/cr-2.0.0/fc-5.0.0/fh-4.0.1/kt-2.12.0/r-3.0.1/sc-2.4.1/sb-1.7.0/sp-2.3.0/datatables.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

    <script>
        var table = $('#abastecimentoTable').DataTable({
    responsive: true,
    columnDefs: [
        { responsivePriority: 1, targets: 0 }, // ID
        { responsivePriority: 1, targets: 1 }, // Data
        { responsivePriority: 3, targets: 2 }, // Veículo
        { responsivePriority: 1, targets: -1 }  // Ações - sempre visível
    ],
    language: {
        url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
    },
    dom: 'Bfrtip',
    buttons: [
        { extend: 'copyHtml5', text: '<i class="fas fa-copy"></i>', titleAttr: 'Copiar' },
        { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i>', titleAttr: 'Excel' },
        { extend: 'csvHtml5', text: '<i class="fas fa-file-csv"></i>', titleAttr: 'CSV' },
        { extend: 'print', text: '<i class="fas fa-print"></i>', titleAttr: 'Imprimir' }
    ],
        initComplete: function() {
                // Ajusta o tamanho da fonte e o alinhamento
                $('#abastecimentoTable').css('font-size', '14px');
                $('#abastecimentoTable th, #abastecimentoTable td').css('font-size', '14px');

                // Alinha os botões à direita
                $('.dt-buttons').css({
                    'float': 'right',
                    'margin-top': '10px' // Um pequeno espaço entre a tabela e os botões
                });

                // Ajusta o tamanho dos botões
                $('.dt-button').css('font-size', '14px'); // Ajuste o tamanho da fonte para os botões
                $('.dt-button').addClass('btn-sm'); // Tamanho pequeno dos botões (Bootstrap)
            }
        })
    </script>
@stop
