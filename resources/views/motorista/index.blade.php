<?php
use Carbon\Carbon;
?>

@extends('adminlte::page')

@section('title', 'Gerenciamento de Motoristas')

@section('content_header')
    <h1>Gerenciamento de Motoristas</h1>
    <hr>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col">
            <!-- Botão para abrir uma nova tela -->
            <a href="{{ route('motoristas.create') }}" class="btn bluebtn float-end rounded-pill"><i class="fa fa-plus"></i> Novo Motorista</a>
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
                <th>Cartão</th>
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
                    <td>{{ $motorista['id_cartao'] }}</td>
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
    
@stop

@section('js')
   
@stop
