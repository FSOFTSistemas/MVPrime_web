<?php
use Carbon\Carbon;
?>

@extends('adminlte::page')

@section('title', 'Log do Sistema')

@section('content_header')
    <h1>Log do sistema</h1>
@stop

@section('content')


    <!-- DataTable Customizado -->
    @component('components.data-table', [
        'responsive' => [
            ['responsivePriority' => 2, 'targets' => 0],
            ['responsivePriority' => 1, 'targets' => 1],
            ['responsivePriority' => 3, 'targets' => 2],
            ['responsivePriority' => 4, 'targets' => -1],
        ],
        'itemsPerPage' => 10,
        'showTotal' => false,
        'valueColumnIndex' => 1,
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
