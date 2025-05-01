@extends('adminlte::page')

@section('title', 'Gerenciamento de Veiculos')

@section('content_header')
    <h1>Gerenciamento de Veiculos</h1>
    <hr>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col">
            <!-- Botão para abrir uma nova tela -->
            <a href="{{ route('veiculos.create') }}" class="btn bluebtn float-end rounded-pill"><i class="fa fa-plus"></i> Novo Veiculo</a>
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
                <th>PLACA</th>
                <th>MODELO</th>
                <th>ANO</th>
                <th>QTD DE LITROS MAXIMO</th>
                <th>QTD DE ABASTECIMENTOS</th>
                <th>PERÍODO DE LIMITE</th>
                <th>SECRETARIA</th>
                <th>AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($veiculos ?? [] as $veiculo)
                <tr>
                    <td>{{ $veiculo['id'] }}</td>
                    <td>{{ $veiculo['placa'] }}</td>
                    <td>{{ $veiculo['modelo'] }}</td>
                    <td>{{ $veiculo['ano'] }}</td>
                    <td>{{ $veiculo['quantidade_litros'] }}</td>
                    <td>{{ $veiculo['quantidade_abastecimentos'] }}</td>
                    <td>
                        @if ($veiculo['limite_abastecimento_periodo'] == 1)
                            Dia
                        @elseif ($veiculo['limite_abastecimento_periodo'] == 2)
                            Semana
                        @elseif ($veiculo['limite_abastecimento_periodo'] == 3)
                            Mês
                        @else
                            Indefinido
                        @endif
                    </td>

                    <td>{{ $veiculo['secretaria']['nome'] }}</td>
                    <td>
                        <!-- Botão Editar -->
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#editVeiculoModal{{ $veiculo['id'] }}">
                            ✏️
                        </button>
                        <!-- Botão Excluir -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteVeiculoModal{{ $veiculo['id'] }}">
                            🗑️
                        </button>
                    </td>
                </tr>

                <!-- Modal Editar -->
                @include('veiculo.modals.edit', ['veiculo' => $veiculo])

                <!-- Modal Excluir -->
                @include('veiculo.modals.delete', ['veiculo' => $veiculo])
            @endforeach
        </tbody>
    @endcomponent

@stop

@section('css')
    
@stop

@section('js')
    
@stop
