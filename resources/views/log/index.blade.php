<?php
use Carbon\Carbon;
?>

@extends('adminlte::page')

@section('title', 'Log do Sistema')

@section('content_header')
    <h1>Log do sistema</h1>
@stop

@section('content')

    @php
        // Gera um ID único para a tabela
        $uniqueId = 'myTable_' . uniqid();
        // Definindo o número de itens por página
        $itemsPerPage = 30;  // Você pode modificar esse valor conforme necessário
        // Configurações de responsividade
        $responsive = [
            ['responsivePriority' => 2, 'targets' => 0],
            ['responsivePriority' => 1, 'targets' => 1],
            ['responsivePriority' => 3, 'targets' => 2],
            ['responsivePriority' => 4, 'targets' => -1],
        ];
        $sortColumnIndex = 0;  // Padrão: ordenar pela primeira coluna
        $sortDirection = 'desc';  // Padrão: ordenação crescente
@endphp

    <!-- DataTable Customizado -->
    @component('components.data-table', [
        'responsive' => $responsive,  // Passando a variável responsiva para o componente
        'itemsPerPage' => $itemsPerPage,  // Passando o valor correto para o componente
        'showTotal' => false,
        'valueColumnIndex' => 1,
        'sortColumnIndex' => $sortColumnIndex, 
        'sortDirection' => $sortDirection

    ])
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Log</th>
                <th>Nível</th>
                <th>Usuario</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs ?? [] as $log)
                <tr>
                    <td>{{ $log['id'] }}</td>
                    <td>{{ $log['log'] }}</td>
                    <td>{{ $log['nivel'] }}</td> 
                    <td>{{ $log['usuario']['nome'] }}</td> 
                    <td>{{ Carbon::parse($log['timestamp'])->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    @endcomponent

@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
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
            // Inicializar o DataTable usando o ID único da tabela
            var table = $('#{{ $uniqueId }}').DataTable({
                responsive: true,
                pageLength: {{ $itemsPerPage }},
                columnDefs: {{ Js::from($responsive) }},
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json'
                },
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copyHtml5',
                        text: '<i class="fas fa-copy"></i>', // Ícone de copiar
                        titleAttr: 'Copiar para a área de transferência',
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i>', // Ícone de Excel
                        titleAttr: 'Exportar para Excel',
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fas fa-file-csv"></i>', // Ícone de CSV
                        titleAttr: 'Exportar para CSV',
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i>', // Ícone de PDF
                        titleAttr: 'Exportar para PDF',
                        orientation: 'landscape',
                        pageSize: 'A4'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i>', // Ícone de Impressora
                        titleAttr: 'Imprimir tabela',
                    }
                ],
            });
        });
    </script>
@stop
