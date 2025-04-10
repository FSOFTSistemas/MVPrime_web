<?php
use Carbon\Carbon;
?>

@extends('adminlte::page')

@section('title', 'Gerenciamento de Motoristas')

@section('content_header')
    <h1>Gerenciamento de Motoristas</h1>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col">
            <!-- Botão para abrir uma nova tela -->
            <a href="{{ route('motoristas.create') }}" class="btn btn-success float-end">+ Novo Motorista</a>
        </div>
    </div>

    <!-- DataTable Customizado -->
    @component('components.data-table', [
        'responsive' => [
            ['responsivePriority' => 1, 'targets' => 0],
            ['responsivePriority' => 2, 'targets' => 1],
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
                <th>Nome</th>
                <th>Vencimento da CNH</th>
                <th>Secretaria</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($motoristas ?? [] as $motorista)
                <tr>
                    <td>{{ $motorista['id'] }}</td>
                    <td>{{ $motorista['nome'] }}</td>
                    <td>{{ Carbon::parse($motorista['vencimento_cnh'])->format('d/m/Y') }}</td>
                    <td>{{ $motorista['secretaria']['nome'] }}</td>
                    <td>
                        <!-- Botão Editar -->
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#editMotoristaModal{{ $motorista['id'] }}">
                            ✏️
                        </button>
                        <!-- Botão Excluir -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteMotoristaModal{{ $motorista['id'] }}">
                            🗑️
                        </button>
                    </td>
                </tr>

                <!-- Modal Editar -->
                @include('motorista.modals.edit', ['motorista' => $motorista])

                <!-- Modal Excluir -->
                @include('motorista.modals.delete', ['motorista' => $motorista])
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
