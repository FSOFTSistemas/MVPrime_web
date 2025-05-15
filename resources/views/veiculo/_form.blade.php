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
                            <input type="text"
                                class="form-control @error('placa') is-invalid @elseif(old('placa')) is-valid @enderror"
                                id="placa" name="placa" value="{{ old('placa') }}" maxlength="7" required
                                style="text-transform:uppercase;">

                            <div id="placa-feedback" class="invalid-feedback" style="display: none;">
                                A placa informada é inválida. Use o formato ABC1234 ou ABC1D23.
                            </div>
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
                        <input type="text" class="form-control ano-picker" name="ano" value="{{ old('ano') }}"
                            required>
                        @error('ano')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 label-control">* Qtd de litros máxima:</label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="quantidade_litros"  min="1" max="650" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 label-control">* Qtd de abastecimentos:</label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="quantidade_abastecimentos" required>
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

                 <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('veiculos.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-primary w-50">
                        <i class="fas fa-save me-1"></i> Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <!-- Adicione a lib jQuery Mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- JS do Datepicker + dependências -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js">
    </script>

    <script>
        $(function() {
            $('.ano-picker').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                language: "pt-BR",
                autoclose: true
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const placaInput = document.getElementById('placa');
            const feedback = document.getElementById('placa-feedback');

            function validarPlaca(placa) {
                placa = placa.toUpperCase();
                const antiga = /^[A-Z]{3}[0-9]{4}$/;
                const mercosul = /^[A-Z]{3}[0-9][A-Z][0-9]{2}$/;
                return antiga.test(placa) || mercosul.test(placa);
            }

            placaInput.addEventListener('input', function() {
                let valor = this.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 7);
                this.value = valor;

                if (valor.length === 7) {
                    if (validarPlaca(valor)) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                        feedback.style.display = 'none';
                    } else {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                        feedback.style.display = 'block';
                    }
                } else {
                    this.classList.remove('is-valid', 'is-invalid');
                    feedback.style.display = 'none';
                }
            });
        });
    </script>


@endsection
