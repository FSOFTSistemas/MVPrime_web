@extends('adminlte::page')

@section('title', 'Cadastrar Veiculo')

@section('content_header')
    <h1>Novo Veiculo</h1>
    <hr>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('veiculos.store') }}" method="POST" id="form-veiculo">
                @csrf

                <div class="form-group row">
                    <label for="placa" class="col-md-3 label-control">* Placa:</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" id="placa" name="placa" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-md-3 label-control">* Modelo:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="modelo" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-md-3 label-control">* Ano:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="ano" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-md-3 label-control">* Qtd de litros máxima:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="quantidade_litros" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-md-3 label-control">* Qtd de abastecimentos:</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="quantidade_abastecimentos" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-md-3 label-control">* Período de limite:</label>
                    <div class="col-md-6">
                        <select class="form-control" name="limite_abastecimento_periodo" required>
                            <option value="" selected disabled>Selecione um período</option>
                            <option value="1">Dia</option>
                            <option value="2">Semana</option>
                            <option value="3">Mês</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="secretaria_id" class="col-md-3 label-control">* Secretaria:</label>
                    <div class="col-md-6">
                        <select class="form-control" id="secretaria" name="secretaria_id" required>
                            <option value="">Selecione uma Secretaria</option>
                            @foreach ($secretarias ?? [] as $secretaria)
                                <option value="{{ $secretaria['id'] }}">
                                    {{ $secretaria['nome'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                

                <div class="card-footer">
                    <a href="{{ route('veiculos.index') }}" class="btn btn-secondary">Voltar</a>
                    <button type="submit" class="btn bluebtn">Salvar</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

@endsection