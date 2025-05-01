@extends('adminlte::page')

@section('title', 'Gerenciamento de Empresas')

@section('content_header')
    <h1 class="text-dark">Gerenciamento de Empresas</h1>
    <hr>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col">
            <!-- Botão para abrir uma nova tela -->
            <a href="{{ route('empresas.create') }}" class="btn bluebtn float-end rounded-pill"><i class="fa fa-plus"></i> Nova Empresa</a>
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
        <thead style="background-color: #1E3A5F; color: white;">
            <tr>
                <th>ID</th>
                <th>CNPJ</th>
                <th>Razão Social</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empresas ?? [] as $empresa)
                <tr>
                    <td>{{ $empresa['id'] }}</td>
                    <td>{{ $empresa['cnpj'] }}</td>
                    <td>{{ $empresa['razao_social'] }}</td>
                    <td>
                        <!-- Botão Editar -->
                        <button type="button" class="btn btn-warning btn-sm rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#editEmpresaModal{{ $empresa['id'] }}">
                            ✏️ Editar
                        </button>
                        <!-- Botão Excluir -->
                        <button type="button" class="btn btn-danger btn-sm rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#deleteEmpresaModal{{ $empresa['id'] }}">
                            🗑️ Excluir
                        </button>
                    </td>
                </tr>

                <!-- Modal Editar -->
                @include('empresa.modals.edit', ['empresa' => $empresa])

                <!-- Modal Excluir -->
                @include('empresa.modals.delete', ['empresa' => $empresa])
            @endforeach
        </tbody>
    @endcomponent

    <!-- Modal Criar -->
    @include('empresa.modals.create')
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <style>
        /* Custom Styles */
        .btn-primary {
            background-color:rgb(3, 34, 75);
            border-color:rgb(1, 35, 78);
        }

        .btn-primary:hover {
            background-color:rgb(3, 37, 68);
            border-color:rgb(3, 39, 73);
        }

        .btn-warning {
            background-color:rgb(238, 255, 0);
            border-color:rgb(5, 16, 116);
        }

        .btn-danger {
            background-color:rgb(204, 14, 0);
            border-color: #F44336;
        }

        .btn-sm {
            padding: 6px 12px;
        }

        .modal-header {
            background-color: #1E3A5F;
            color: #fff;
        }

        .modal-footer {
            background-color: #f1f1f1;
        }

        .dataTable thead th {
            background-color: #1E3A5F;
            color: #fff;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 4px;
            border: 1px solid #1E3A5F;
        }
    </style>
@stop

@section('js')
    
@stop
