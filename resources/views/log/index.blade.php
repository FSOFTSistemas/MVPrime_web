<?php
use Carbon\Carbon;
?>

@extends('adminlte::page')

@section('title', 'Log do Sistema')

@section('content_header')
    <h1>Log do sistema</h1>
    <hr>
@stop

@section('content')

    @php
        // Gera um ID único para a tabela
        $uniqueId = 'myTable_' . uniqid();
        // Definindo o número de itens por página
        $itemsPerPage = 30;  // Você pode modificar esse valor conforme necessário
        // Configurações de responsividade
        $responsive = [
            ['responsivePriority' => 2, 'targets' => 0],
            ['responsivePriority' => 1, 'targets' => 1],
            ['responsivePriority' => 3, 'targets' => 2],
            ['responsivePriority' => 4, 'targets' => -1],
        ];
        $sortColumnIndex = 0;  // Padrão: ordenar pela primeira coluna
        $sortDirection = 'desc';  // Padrão: ordenação crescente
@endphp

    <!-- DataTable Customizado -->
    @component('components.data-table', [
        'responsive' => $responsive,  // Passando a variável responsiva para o componente
        'itemsPerPage' => $itemsPerPage,  // Passando o valor correto para o componente
        'showTotal' => false,
        'valueColumnIndex' => 1,
        'sortColumnIndex' => $sortColumnIndex, 
        'sortDirection' => $sortDirection

    ])
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Log</th>
                <th>Nível</th>
                <th>Usuario</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs ?? [] as $log)
                <tr>
                    <td>{{ $log['id'] }}</td>
                    <td>{{ $log['log'] }}</td>
                    <td>{{ $log['nivel'] }}</td> 
                    <td>{{ $log['usuario']['nome'] }}</td> 
                    <td>{{ Carbon::parse($log['timestamp'])->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    @endcomponent

@stop

@section('css')
   
@stop

@section('js')
   
@stop
