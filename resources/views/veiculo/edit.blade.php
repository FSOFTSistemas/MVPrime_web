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
                    <label class="col-md-3 label-control">Modelo <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="modelo" value="{{ $veiculo['modelo'] }}"
                          required pattern="[A-Za-zÀ-ÿ0-9\s]{3,}"
                          title="Use apenas letras e números, mínimo de 3 caracteres">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 label-control">Ano <span class="text-danger">*</span></label>
                    <div class="col-md-3">
                      <input type="number" class="form-control" name="ano" required min="1960"
                          max="{{ date('Y') + 1 }}" step="1" placeholder="Ex: 2024" value="{{ $veiculo['ano'] }}">
                    </div>
                    @error('ano')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group row">
                    <label class="col-md-3 label-control">Qtd de litros máxima <span class="text-danger">*</span></label>
                    <div class="col-md-3">
                      <input type="number" class="form-control" name="quantidade_litros"
                          value="{{ $veiculo['quantidade_litros'] }}" min="1" max="100" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 label-control">Qtd de abastecimentos <span class="text-danger">*</span></label>
                    <div class="col-md-3">
                      <input type="number" class="form-control" name="quantidade_abastecimentos"
                          value="{{ $veiculo['quantidade_abastecimentos'] }}" min="1" max="100" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 label-control">Período de limite <span class="text-danger">*</span></label>
                    <div class="col-md-3">
                      <select class="form-control" name="limite_abastecimento_periodo" required>
                          <option value="1" {{ $veiculo['limite_abastecimento_periodo'] == 1 ? 'selected' : '' }}>Dia</option>
                          <option value="2" {{ $veiculo['limite_abastecimento_periodo'] == 2 ? 'selected' : '' }}>Semana</option>
                          <option value="3" {{ $veiculo['limite_abastecimento_periodo'] == 3 ? 'selected' : '' }}>Mês</option>
                      </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="secretaria_id" class="col-md-3 label-control">Secretaria<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        @php
                        $secretariasSelecionadas = array_column($veiculo['secretarias'] ?? [], 'id');
                            // $secretariasSelecionadas = $veiculo['secretarias'] ?? [];
                            // dd($secretariasSelecionadas); 
                        @endphp

                        <select class="form-control select2" id="secretaria" name="secretarias_ids[]" multiple required>
                            @foreach ($secretarias ?? [] as $secretaria)
                                <option value="{{ $secretaria['id'] }}"
                               
                                    @if (in_array($secretaria['id'], $secretariasSelecionadas)) selected @endif>
                                    {{ $secretaria['nome'] }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                </div>


            <div class="card-footer d-flex justify-content-between">
                 <a href="{{ route('veiculos.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Voltar
                </a>
                <button type="submit" class="btn bluebtn w-50"><i class="fas fa-save me-1"></i> Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-selection__choice {
            color: var(--blue-2) !important;
            padding-left: 1.5rem !important;
        }
    </style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#secretaria').select2({
            placeholder: "Selecione as secretarias",
            allowClear: true,
            width: '100%'
        });
    })
</script>
@stop
