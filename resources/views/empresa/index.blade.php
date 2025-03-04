@extends('adminlte::page')

@section('title', 'Lista de Empresas')

@section('content_header')
    <h1>Lista de Empresas</h1>
@stop

@section('content')
    <x-data-table
        id="empresaTable"
        :columns="[
            ['title' => 'ID', 'data' => 'id'],
            ['title' => 'Nome', 'data' => 'name'],
            ['title' => 'CNPJ', 'data' => 'cnpj'],
            ['title' => 'Ações', 'data' => 'actions']
        ]"
        :data="$empresas"
        sumColumn="cnpj"
        sumEnabled="true"
    />
@stop