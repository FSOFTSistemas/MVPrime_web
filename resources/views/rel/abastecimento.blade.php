@extends('adminlte::page')

@section('title', 'Relatório de Abastecimentos')

@section('content_header')
    <h1>Relatório de Abastecimentos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('relatorios.abastecimentos.pdf') }}" method="GET" target="_blank">
                <div class="row">
                    <div class="col-md-3">
                        <label for="data_inicio">Data Início</label>
                        <input type="date" name="data_inicio" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="data_fim">Data Fim</label>
                        <input type="date" name="data_fim" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="placa">Placa</label>
                        <input type="text" name="placa" class="form-control" placeholder="Ex: ABC-1234">
                    </div>
                    <div class="col-md-3">
                        <label for="motorista">Motorista</label>
                        <input type="text" name="motorista" class="form-control" placeholder="Nome do motorista">
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="tipo_combustivel">Tipo de Combustível</label>
                        <select name="tipo_combustivel" class="form-control">
                            <option value="">-- Todos --</option>
                            <option value="Gasolina">Gasolina</option>
                            <option value="Etanol">Etanol</option>
                            <option value="Diesel">Diesel</option>
                            <option value="GNV">GNV</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-file-pdf"></i> Gerar PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
