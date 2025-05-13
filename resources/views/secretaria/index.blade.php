@extends('adminlte::page')

@section('title', 'Gerenciamento de Secretarias')

@section('content_header')
    <h1>Gerenciamento de Secretarias</h1>
    <hr>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col">
            <!-- Botão para abrir uma nova tela -->
            <a href="{{ route('secretarias.create') }}" class="btn bluebtn float-end rounded-pill"><i class="fa fa-plus"></i>
                Nova Secretaria</a>
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
                <th>Responsável</th>
                <th>Prefeitura</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($secretarias ?? [] as $secretaria)
                <tr>
                    <td>{{ $secretaria['id'] }}</td>
                    <td>{{ $secretaria['nome'] }}</td>
                    <td>{{ $secretaria['responsavel'] }}</td>
                    <td>{{ $secretaria['prefeitura']['razao_social'] }}</td>
                    <td>
                        <!-- Botão Editar -->
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#editSecretariaModal{{ $secretaria['id'] }}">
                            ✏️
                        </button>
                        <!-- Botão Excluir -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteSecretariaModal{{ $secretaria['id'] }}">
                            🗑️
                        </button>
                    </td>
                </tr>

                <!-- Modal Editar -->
                @include('secretaria.modals.edit', ['secretaria' => $secretaria])

                <!-- Modal Excluir -->
                @include('secretaria.modals.delete', ['secretaria' => $secretaria])
            @endforeach
        </tbody>
    @endcomponent

@stop

@section('css')

@stop

@section('js')

@stop
