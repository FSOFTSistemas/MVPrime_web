@extends('adminlte::page')

@section('title', 'Cadastrar Motorista')

@section('content_header')
<h1>Novo Motorista</h1>
<hr>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('motoristas.store') }}" method="POST" id="form-motorista">
            @csrf

            <div class="form-group row">
                <label for="nome" class="col-md-3 label-control">* Nome:</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="cnh" class="col-md-3 label-control">* CNH:</label>
                <div class="col-md-6">
                    <input type="text" 
                           class="form-control" 
                           id="cnh" 
                           name="cnh" 
                           required 
                           minlength="7" 
                           maxlength="11"
                           inputmode="numeric"
                           pattern="\d{7,11}">
                    <div class="invalid-feedback">Digite entre 7 e 11 números.</div>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="vencimento_cnh" class="col-md-3 label-control">* Vencimento da CNH:</label>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="vencimento_cnh" name="vencimento_cnh" required>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="secretaria_id" class="col-md-3 label-control">* Secretaria:</label>
                <div class="col-md-3">
                    <select class="form-control" id="secretaria" name="secretaria_id" required>
                        <option value="">Selecione uma Secretaria</option>
                        @forelse ($secretarias ?? [] as $secretaria)
                            <option value="{{ $secretaria['id'] }}">
                                {{ $secretaria['nome'] }}
                            </option>
                        @empty
                            <option value="" disabled>Sem secretarias disponíveis</option>
                        @endforelse
                    </select>
                </div>
            </div>

            <div class="form-group row input-container">
                <label for="id_cartao" class="col-md-3 label-control" >Cartão:</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="id_cartao" name="id_cartao" maxlength="30">
                        <i class="fas fa-info-circle info-icon"></i>
                        <div class="info-tooltip">
                            <strong>Aviso:</strong> Sem esta informação não será possível realizar abastecimento!
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="card-footer">
                <a href="{{ route('motoristas.index') }}" class="btn btn-secondary">Voltar</a>
                <button type="submit" class="btn bluebtn">Salvar</button>
            </div>
        </form>
    </div>
</div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .info-icon {
            position: absolute;
            right: 10px;
            top: 10px;
            color: #007bff;
            cursor: pointer;
        }

        .info-tooltip {
            display: none;
            position: absolute;
            top: 35px;
            right: 0;
            color: white;
            background-color: var(--blue-1);
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            width: 300px;
            box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
        }
    
        .info-icon:hover + .info-tooltip {
            display: block;
        }
</style>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#cnh').mask('00000000000', {
                translation: { '0': { pattern: /[0-9]/ } },
                onKeyPress: function(val, e, field, options) {
                    let length = val.replace(/\D/g, '').length;
                    if (length < 7) {
                        field.removeClass('is-valid').addClass('is-invalid');
                    } else {
                        field.removeClass('is-invalid').addClass('is-valid');
                    }
                }
            });
        });
    </script>
@endsection

