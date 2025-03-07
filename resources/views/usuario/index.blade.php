@extends('adminlte::page')

@section('title', 'Gerenciamento de Usuários')

@section('content_header')
    <h1>Gerenciamento de Usuários</h1>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col">
            <!-- Botão para abrir o modal de criação -->
            <button class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#createUsuarioModal">+ Novo
                Usuário</button>
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
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario['id'] }}</td>
                    <td>{{ $usuario['nome'] }}</td>
                    <td>{{ $usuario['email'] }}</td>
                    <td>
                        <!-- Botão Visualizar -->
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                            data-bs-target="#viewUsuarioModal{{ $usuario['id'] }}">
                            👁️
                        </button>
                        <!-- Botão Editar -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editUsuarioModal{{ $usuario['id'] }}">
                            ✏️
                        </button>
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

    <!-- Modal Criar -->
    @include('usuario.modals.create')

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
            $('.select2').select2();
        });
    </script>
@stop
