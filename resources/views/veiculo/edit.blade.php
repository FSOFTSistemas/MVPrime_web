@extends('adminlte::page')

@section('title', 'Editar Veículo')

@section('content_header')
    <h1>Editar Veículo</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('veiculos.update', $veiculo['id']) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group row">
                    <label class="col-md-3 label-control">Modelo <span class="tex-danger">*</span></label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="modelo" value="{{ $veiculo['modelo'] }}"
                          required pattern="[A-Za-zÀ-ÿ0-9\s]{3,}"
                          title="Use apenas letras e números, mínimo de 3 caracteres">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 label-control">Ano <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                      <input type="number" class="form-control" name="ano" required min="1960"
                          max="{{ date('Y') + 1 }}" step="1" placeholder="Ex: 2024" value="{{ $veiculo['ano'] }}">
                    </div>
                    @error('ano')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group row">
                    <label class="col-md-3 label-control">Qtd de litros máxima <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                      <input type="number" class="form-control" name="quantidade_litros"
                          value="{{ $veiculo['quantidade_litros'] }}" min="1" max="100" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 label-control">Qtd de abastecimentos <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                      <input type="number" class="form-control" name="quantidade_abastecimentos"
                          value="{{ $veiculo['quantidade_abastecimentos'] }}" min="1" max="100" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 label-control">Período de limite <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                      <select class="form-control" name="limite_abastecimento_periodo" required>
                          <option value="1" {{ $veiculo['limite_abastecimento_periodo'] == 1 ? 'selected' : '' }}>Dia</option>
                          <option value="2" {{ $veiculo['limite_abastecimento_periodo'] == 2 ? 'selected' : '' }}>Semana</option>
                          <option value="3" {{ $veiculo['limite_abastecimento_periodo'] == 3 ? 'selected' : '' }}>Mês</option>
                      </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 label-control">Secretaria <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                      <select class="form-control select2" name="secretaria_id" required>
                          @foreach ($secretarias as $secretaria)
                              <option value="{{ $secretaria['id'] }}"
                                  {{ $veiculo['secretaria_id'] == $secretaria['id'] ? 'selected' : '' }}>
                                  {{ $secretaria['nome'] }}
                              </option>
                          @endforeach
                      </select>
                    </div>
                </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-warning text-white w-100">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function () {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    });
</script>
@stop
