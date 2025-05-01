@extends('adminlte::page')

@section('title', 'Gerenciamento de Postos')

@section('content_header')
    <h1>Gerenciamento de Postos</h1>
    <hr>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col">
            <!-- Botão para abrir uma nova tela -->
            <a href="{{ route('postos.create') }}" class="btn bluebtn float-end rounded-pill"><i class="fa fa-plus"></i> Novo Posto</a>
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
                <th>Nome</th>
                <th>Responsável</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($postos ?? [] as $posto)
                <tr>
                    <td>{{ $posto['id'] }}</td>
                    <td>{{ $posto['cnpj'] }}</td>
                    <td>{{ $posto['nome'] }}</td>
                    <td>{{ $posto['responsavel'] }}</td>
                    <td>
                        <!-- Botão Editar -->
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#editPostoModal{{ $posto['id'] }}">
                            ✏️
                        </button>
                        <!-- Botão Excluir -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deletePostoModal{{ $posto['id'] }}">
                            🗑️
                        </button>
                    </td>
                </tr>

                <!-- Modal Editar -->
                @include('posto.modals.edit', ['posto' => $posto])

                <!-- Modal Excluir -->
                @include('posto.modals.delete', ['posto' => $posto])
            @endforeach
        </tbody>
    @endcomponent

@stop

@section('css')
   
@stop

@section('js')
   
@stop
