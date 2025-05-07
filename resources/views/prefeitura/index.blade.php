@extends('adminlte::page')

@section('title', 'Gerenciamento de Prefeituras')

@section('content_header')
    <h1>Gerenciamento de Prefeituras</h1>
    <hr>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col">
            <!-- Botão para abrir uma nova tela -->
            <a href="{{ route('prefeituras.create') }}" class="btn bluebtn float-end rounded-pill"><i class="fa fa-plus"></i> Nova Prefeitura</a>
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
                <th>CNPJ</th>
                <th>Razão Social</th>
                <th>Responsável</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @php
                $listaPrefeituras = $prefeituras ? $prefeituras : [];
            @endphp
            @foreach ($listaPrefeituras ?? [] as $prefeitura)
                <tr>
                    <td>{{ $prefeitura['id'] }}</td>
                    <td>{{ $prefeitura['cnpj'] }}</td>
                    <td>{{ $prefeitura['razao_social'] }}</td>
                    <td>{{ $prefeitura['responsavel'] }}</td>
                    <td>
                        <!-- Botão Editar -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editPrefeituraModal{{ $prefeitura['id'] }}">
                            ✏️
                        </button>
                        <!-- Botão Excluir -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deletePrefeituraModal{{ $prefeitura['id'] }}">
                            🗑️
                        </button>
                    </td>
                </tr>

                <!-- Modal Editar -->
                @include('prefeitura.modals.edit', ['prefeitura' => $prefeitura])

                <!-- Modal Excluir -->
                @include('prefeitura.modals.delete', ['prefeitura' => $prefeitura])
            @endforeach
        </tbody>
    @endcomponent

@stop

@section('css')
   
@stop

@section('js')
    
@stop
