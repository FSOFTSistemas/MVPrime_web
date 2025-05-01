@extends('adminlte::page')

@section('title', 'Criar Novo Usuário')

@section('content_header')
    <h1>Criar Novo Usuário</h1>
    <hr>
@stop

@section('content')
            <div class="card">
                <form method="POST" action="{{ route('usuarios.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="nome" class="col-md-3 label-control">* Nome:</label>
                            <div class="col-md-6">
                                <input type="text" name="nome" id="nome" class="form-control" required placeholder="Digite o nome">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="email" class="col-md-3 label-control">* Email:</label>
                            <div class="col-md-6">
                                <input type="email" name="email" id="email" class="form-control" required placeholder="Digite o email">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="password" class="col-md-3 label-control">* Senha:</label>
                            <div class="col-md-6">
                                <input type="password" name="password" id="password" class="form-control" required placeholder="Digite a senha">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-md-3 label-control">* Confirmar Senha:</label>
                            <div class="col-md-6">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Confirme a senha">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="prefeitura_id" class="col-md-3 label-control">* Prefeitura:</label>
                            <div class="col-md-6">
                                <select name="prefeitura_id" id="prefeitura_id" class="form-control select2" required data-placeholder="Selecione a Prefeitura">
                                    <option value="">Selecione a Prefeitura</option>
                                    @foreach ($prefeituras as $prefeitura)
                                        <option value="{{ $prefeitura['id'] }}">{{ $prefeitura['razao_social'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo_usuario" class="col-md-3 label-control">* Tipo de usuário:</label>
                            <div class="col-md-6">
                                <select name="tipo_usuario" id="tipo_usuario" class="form-control" required data-placeholder="Selecione o tipo">
                                    <option value="">Selecione o tipo</option>
                                        <option value="1">Master</option>
                                        <option value="2">Posto</option>
                                        <option value="3">Prefeitura</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="permissoes" class="col-md-3 label-control">* Permissões:</label>
                            <div class="col-md-6">
                                <div class=" mb-2">
                                    <button type="button" class="btn btn-sm btn-success" id="select-all">Selecionar Todas</button>
                                    <button type="button" class="btn btn-sm btn-danger" id="deselect-all">Limpar Seleção</button>
                                </div>
                        
                                <select name="permissoes[]" id="permissoes" class="form-select select2" multiple required data-placeholder="Selecione permissões">
                                    @foreach ($permissoes as $permission)
                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        
                        
                        

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn bluebtn">Criar Usuário</button>
                    </div>
                </form>
            </div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-selection__choice{
            color: var(--blue-2) !important;
            padding-left: 1.5rem !important;
        }
        .select2-container--default .select2-selection--multiple {

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
    </script>
@stop
