@extends('adminlte::page')

@section('title', 'Criar Novo Usuário')

@section('content_header')
    <h1>Criar Novo Usuário</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Novo Usuário</h3>
                </div>
                <form method="POST" action="{{ route('usuarios.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control" required
                                placeholder="Digite o nome">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required
                                placeholder="Digite o email">
                        </div>

                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" name="password" id="password" class="form-control" required
                                placeholder="Digite a senha">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Senha</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required placeholder="Confirme a senha">
                        </div>

                        <div class="form-group">
                            <label for="prefeitura">Prefeitura</label>
                            <select name="prefeitura_id" id="prefeitura_id" class="form-control select2" required
                                data-placeholder="Selecione a Prefeitura">
                                <option value="">Selecione a Prefeitura</option>
                                @foreach ($prefeituras as $prefeitura)
                                    <option value="{{ $prefeitura['id'] }}">{{ $prefeitura['razao_social'] }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="permissoes">Permissões</label>

                            <div class="mb-2">
                                <button type="button" class="btn btn-sm btn-success" id="select-all">Selecionar
                                    Todas</button>
                                <button type="button" class="btn btn-sm btn-danger" id="deselect-all">Limpar
                                    Seleção</button>
                            </div>

                            <select name="permissoes[]" id="permissoes" class="form-control select2" multiple="multiple"
                                required data-placeholder="Selecione permissões">
                                @foreach ($permissoes as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Criar Usuário</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Select2 CSS com tema Bootstrap 4 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css"
        rel="stylesheet" />

    <style>
        /* Deixar o campo Select2 mais alto */
        .select2-container--bootstrap4 .select2-selection--multiple {
            min-height: 300px;
            /* Você pode ajustar a altura aqui */
            padding: 0.5rem;
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
                theme: 'bootstrap4',
                placeholder: "Selecione permissões",
                allowClear: true
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
