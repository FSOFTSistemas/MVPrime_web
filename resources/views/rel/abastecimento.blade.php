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
                        <select name="veiculo_id" id="veiculo_id" class="form-select select2 " data-placeholder="-- Todos --">
                            <option value="">-- Todos --</option>
                            @foreach ($veiculos as $veiculo)
                                <option value="{{ $veiculo['id'] }}">{{ $veiculo['placa'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="motorista">Motorista</label>
                        <select name="motorista" class="form-control">
                            <option value="">-- Todos --</option>
                            @foreach ($motoristas as $chave => $motorista)
                                <option value="{{ $motorista['id'] }}">{{ $motorista['nome'] }}</option>
                            @endforeach
                        </select>
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

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-selection {
            height: calc(2.25rem + 2px) !important;
        }
        .select2-selection__choice{
            color: var(--blue-2) !important;
            
        }
    </style>
@stop

@section('js')
    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#veiculo_id').select2({
                allowClear: true,
                width: '100%',
            });
        });
    </script>
@stop