@extends('adminlte::page')

@section('title', 'Criar Novo Usuário')

@section('content_header')
    <h1>Criar Novo Usuário</h1>
    <hr>
@stop

@section('content')
<div class="alert alert-info alert-dismissible fade show position-relative top-3 end-0 m-3" role="alert">
        <i class="fas fa-info-circle"></i> <strong>Aviso:</strong> Usuários serão cadastrados para a prefeitura selecionada. Para cadastrar um usuário MASTER, selecione a opção "TODOS" no seletor de prefeitura.
    </div>

    <div class="card">
        <form method="POST" action="{{ route('usuarios.store') }}">
            @csrf
            <input type="hidden" name="prefeitura_id" id="prefeitura_id" value="{{ session('prefeitura_id') }}">
            <div class="card-body">
                <div class="form-group row">
                    <label for="nome" class="col-md-3 label-control">* Nome:</label>
                    <div class="col-md-6">
                        <input type="text" name="nome" id="nome" class="form-control" required
                            placeholder="Digite o nome">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-3 label-control">* Email:</label>
                    <div class="col-md-6">
                        <input type="email" name="email" id="email" class="form-control" required
                            placeholder="Digite o email">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-3 label-control">* Senha:</label>
                    <div class="col-md-6">
                        <input type="password" name="password" id="password" class="form-control" required
                            placeholder="Digite a senha">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_confirmation" class="col-md-3 label-control">* Confirmar Senha:</label>
                    <div class="col-md-6">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            required placeholder="Confirme a senha">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tipo_usuario" class="col-md-3 label-control">* Tipo de usuário:</label>
                    <div class="col-md-6">
                        <select name="tipo_usuario" id="tipo_usuario" class="form-control" required
                            data-placeholder="Selecione o tipo">
                            <option value="">Selecione o tipo</option>
                            <option value="1">Master</option>
                            <option value="2">Posto</option>
                            <option value="3">Prefeitura</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row" id="posto-container" style="display: none;">
                    <label for="posto" class="col-md-3 label-control">* Selecionar Posto:</label>
                    <div class="col-md-6">
                        <select name="posto_id" id="posto_id" class="form-control">
                            <option value="" selected disabled>Selecione o Posto</option>
                            @foreach ($postos ?? [] as $posto)
                                <option value="{{ $posto['id'] }}">{{ $posto['nome'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row input-container" id="cartao-container" style="display: none;">
                    <label for="id_cartao" class="col-md-3 label-control">Cartão:</label>
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

                <div class="row mb-3">
                    <label for="permissoes" class="col-md-3 label-control">* Permissões:</label>
                    <div class="col-md-6">
                        <div class=" mb-2">
                            <button type="button" class="btn btn-sm btn-success" id="select-all">Selecionar Todas</button>
                            <button type="button" class="btn btn-sm btn-danger" id="deselect-all">Limpar Seleção</button>
                        </div>

                        <select name="permissoes[]" id="permissoes" class="form-select select2" multiple required
                            data-placeholder="Selecione permissões">
                            @foreach ($permissoes as $permission)
                                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

             <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-primary w-50">
                        <i class="fas fa-save me-1"></i> Salvar
                    </button>
                </div>
        </form>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-selection__choice {
            color: var(--blue-2) !important;
            padding-left: 1.5rem !important;
        }

        .select2-container--default .select2-selection--multiple {}

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
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .info-icon:hover+.info-tooltip {
            display: block;
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
            $('#permissoes').select2({
                placeholder: "Selecione permissões",
                allowClear: true,
                width: '100%'
            });

            // Botão selecionar todas
            $('#select-all').click(function() {
                var allOptions = $('#permissoes option');
                allOptions.prop('selected', true);
                $('#permissoes').trigger('change'); // Atualiza o Select2
            });

            // Botão limpar todas
            $('#deselect-all').click(function() {
                $('#permissoes').val(null).trigger('change'); // Limpa o Select2
            });
        });


        document.getElementById('tipo_usuario').addEventListener('change', function() {
            var tipoUsuario = this.value;
            var postoContainer = document.getElementById('posto-container');
            var postoIdInput = document.getElementById('posto_id');
            var cartaoContainer = document.getElementById('cartao-container');
            var cartaoIdInput = document.getElementById('id_cartao');

            postoContainer.style.display = 'none';
            cartaoContainer.style.display = 'none';
            postoIdInput.required = false;

            if (tipoUsuario == "1") { // exibe o campo de cartão para selecionar
                postoIdInput.value = '';
                cartaoContainer.style.display = 'flex';
            } else if (tipoUsuario == "2") { // exibe os postos para selecionar
                cartaoIdInput.value = '';
                postoContainer.style.display = 'flex';
                postoIdInput.required = true;
            } else {
                postoIdInput.value = '';
                cartaoIdInput.value = '';
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const tipoUsuarioSelect = document.getElementById("tipo_usuario"); 
    const permissoesSelect = $("#permissoes");

    const permissoesPorTipo = {
                1: [],
                2: ["gerenciar_abastecimentos", "ver_empresa", "gerenciar_veiculos", "ver_usuario_idCartao", "gerenciar_motoristas"], 
                3: ["gerenciar_secretarias", "gerenciar_abastecimentos", "gerenciar_enderecos", "gerenciar_postos", "gerenciar_motoristas", "deletar_secretarias", "deletar_veiculos", "deletar_postos", "deletar_motoristas", "deletar_enderecos", "ver_empresa",]
            };

    permissoesPorTipo[1] = Array.from(document.querySelectorAll("#permissoes option")).map(option => option.value)


    tipoUsuarioSelect.addEventListener("change", function () {
        const tipoSelecionado = parseInt(this.value);

        permissoesSelect.val([]);

        if (permissoesPorTipo[tipoSelecionado]) {
            permissoesSelect.val(permissoesPorTipo[tipoSelecionado]).trigger("change");
        }
    });
});


    </script>
@stop
