<?php
use Carbon\Carbon;
?>

@extends('adminlte::page')

@section('title', 'Gerenciamento de Abastecimentos')

@section('content_header')
    <h1>Gerenciamento de Abastecimentos</h1>
@stop

@section('content')
    <!-- DataTable Customizado -->
    @component('components.data-table', [
        'responsive' => [
            ['responsivePriority' => 1, 'targets' => 0],
            ['responsivePriority' => 2, 'targets' => 1],
            ['responsivePriority' => 3, 'targets' => 2],
            ['responsivePriority' => 4, 'targets' => -1],
            ['responsivePriority' => 4, 'targets' => -1],
        ],
        'itemsPerPage' => 10,
        'showTotal' => false,
        'valueColumnIndex' => 1,
    ])

    <!-- "id": 31,
        "valor": 230,
        "data_abastecimento": "2025-03-26T14:43:32.000Z",
        "veiculo_id": 7,
        "abastecimento_id": 1, -->
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
                    <td>{{ Carbon::parse($abastecimento['data_abastecimento'])->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $abastecimento['veiculo']['placa'] }}</td>
                    <td>{{ $abastecimento['motorista']['nome'] }}</td>
                    <td>{{ $abastecimento['posto']['nome'] }}</td>
                    <td>{{ $abastecimento['tipo_combustivel'] }}</td>
                    <td>{{ $abastecimento['km_atual'] }}</td>
                    <td>{{ $abastecimento['media_km_litro'] }}</td>
                    <td>{{ ($abastecimento['valor']/$abastecimento['preco_combustivel']) }}</td>
                    <td>R$ {{ number_format($abastecimento['preco_combustivel'], 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($abastecimento['valor'], 2, ',', '.') }}</td>
                    <td>
                        <!-- Botão Editar -->
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#editAbastecimentoModal{{ $abastecimento['id'] }}">
                            ✏️
                        </button>
                        <!-- Botão Excluir -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteAbastecimentoModal{{ $abastecimento['id'] }}">
                            🗑️
                        </button>
                    </td>
                </tr>

                 <!-- Modal Editar -->
                    @include('abastecimento.modals.edit', ['abastecimento' => $abastecimento])

                <!-- Modal Excluir -->
                    @include('abastecimento.modals.delete', ['abastecimento' => $abastecimento])
            @endforeach
        </tbody>
    @endcomponent

@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Exibir notificação de sucesso
        @if (session('success'))
            Swal.fire({
                title: 'Sucesso!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@stop
