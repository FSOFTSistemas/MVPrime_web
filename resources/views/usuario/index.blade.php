@extends('adminlte::page')

@section('title', 'Gerenciamento de Usuários')

@section('content_header')
    <h1>Gerenciamento de Usuários</h1>
    <hr>
@stop

@section('content')

    <div class="alert alert-info alert-dismissible fade show position-relative top-3 end-0 m-3" role="alert">
        <i class="fas fa-info-circle"></i> <strong>Aviso:</strong> Usuários do tipo MASTER só aparecerão quando o seletor de
        prefeitura estiver em TODOS.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="row mb-3">
        <div class="col">
            <!-- Botão para ir para a tela de criação -->
            <a href="{{ route('usuarios.create') }}" class="btn bluebtn float-end rounded-pill">
                <i class="fa fa-plus"></i> Novo Usuário
            </a>
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
                <th>Email</th>
                <th>Prefeitura</th>
                <th>Tipo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios ?? [] as $usuario)
                <tr>
                    <td>{{ $usuario['id'] }}</td>
                    <td>{{ $usuario['nome'] }}</td>
                    <td>{{ $usuario['email'] }}</td>
                    <td>{{ $usuario['prefeitura']['razao_social'] ?? '---' }}</td>
                    @php
                        $tipos = [0 => 'Super', 1 => 'Master', 2 => 'Posto', 3 => 'Prefeitura'];
                    @endphp
                    <td>{{ $tipos[$usuario['tipo_usuario']] ?? 'Desconhecido' }}</td>
                    <td>
                        <!-- Botão Visualizar -->
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                            data-bs-target="#viewUsuarioModal{{ $usuario['id'] }}">
                            👁️
                        </button>
                        <!-- Botão Editar -->
                        <a href="{{ route('usuarios.edit', $usuario['id'])}}" class="btn btn-warning btn-sm" >
                             ✏️
                        </a>
                        <!-- Botão Excluir -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteUsuarioModal{{ $usuario['id'] }}">
                            🗑️
                        </button>
                    </td>
                </tr>

                <!-- Modal Visualizar -->
                @include('usuario.modals.view', ['usuario' => $usuario])

                <!-- Modal Editar -->
                @include('usuario.modals.edit', ['usuario' => $usuario])

                <!-- Modal Excluir -->
                @include('usuario.modals.delete', ['usuario' => $usuario])
            @endforeach
        </tbody>
    @endcomponent


@stop

@section('css')


@stop

@section('js')

@stop
