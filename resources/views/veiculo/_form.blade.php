@extends('adminlte::page')

@section('title', 'Cadastrar Veiculo')

@section('content_header')
    <h1>Novo Veiculo</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('veiculos.store') }}" method="POST" id="form-veiculo">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nome" class="form-label">Placa</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="placa" name="placa"  required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Modelo</label>
                        <input type="text" class="form-control" name="modelo" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ano</label>
                        <input type="text" class="form-control" name="ano"  required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Qtd de litros máxima</label>
                        <input type="text" class="form-control" name="quantidade_litros" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Qtd de abastecimentos</label>
                        <input type="text" class="form-control" name="quantidade_abastecimentos" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Período de limite</label>
                        <select class="form-control" name="limite_abastecimento_periodo" required>
                            <option value="" selected disabled>Selecione um período</option>
                            <option value="1">Dia</option>
                            <option value="2">Semana</option>
                            <option value="3">Mês</option>
                        </select>
                    </div>



                    <div class="col-12 mb-3">
                        <label for="secretaria_id" class="form-label">Secretaria</label>
                        <select class="form-control" id="secretaria" name="secretaria_id" required>
                            <option value="">Selecione uma Secretaria</option>
                            @foreach ($secretarias as $secretaria)
                                <option value="{{ $secretaria['id'] }}">
                                    {{ $secretaria['nome'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('veiculos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Salvar Veiculo</button>
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