@extends('adminlte::page')

@section('title', 'Gerenciamento de Empresas')

@section('content_header')
    <h1>Gerenciamento de Empresas</h1>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col">
            <!-- Botão para abrir o modal de criação -->
            <button class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#createEmpresaModal">+ Nova Empresa</button>
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
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @if(is_array($empresas) && count($empresas) > 0)
                @foreach ($empresas as $empresa)
                    <tr>
                        <td>{{ $empresa['id'] }}</td>
                        <td>{{ $empresa['cnpj'] }}</td>
                        <td>{{ $empresa['razao_social'] }}</td>
                        <td>
                            <!-- Botão Editar -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editEmpresaModal{{ $empresa['id'] }}">
                                ✏️
                            </button>
                            <!-- Botão Excluir -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteEmpresaModal{{ $empresa['id'] }}">
                                🗑️
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Editar -->
                    @include('empresa.modals.edit', ['empresa' => $empresa])

                    <!-- Modal Excluir -->
                    @include('empresa.modals.delete', ['empresa' => $empresa])
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">Nenhuma empresa encontrada.</td>
                </tr>
            @endif
        </tbody>
    @endcomponent

    <!-- Modal Criar -->
    @include('empresa.modals.create')
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