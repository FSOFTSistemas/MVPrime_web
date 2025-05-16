{{-- resources/views/usuarios/edit.blade.php --}}
@extends('adminlte::page')

@section('title', 'Editar Usuário')

@section('content_header')
    <h1>Editar Usuário</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('usuarios.update', $usuario['id']) }}">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label for="nome" class="col-md-3 label-control">* Nome:</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" id="nome" name="nome"
                          value="{{ old('nome', $usuario['nome']) }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-3 label-control">* Email:</label>
                    <div class="col-md-6">
                      <input type="email" class="form-control" id="email" name="email"
                          value="{{ old('email', $usuario['email']) }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-3 label-control">Nova Senha:</label>
                    <div class="col-md-6">
                      <input type="password" class="form-control" id="password" name="password" placeholder="(deixe em branco para manter a atual)" autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_confirmation" class="col-md-3 label-control">Confirmar Senha</label>
                    <div class="col-md-6">
                      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="(deixe em branco para manter a atual)" autocomplete="off">
                    </div>
                </div>
                
                @if( $usuario['tipo_usuario'] == 1)
                    <div class="form-group row input-container" id="cartao-container" >
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
                @endif
                
                <div class="row mb-3">
                    <label for="permissoes" class="col-md-3 label-control">* Permissões:</label>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <button type="button" class="btn btn-sm btn-success" id="select-all">Selecionar Todas</button>
                            <button type="button" class="btn btn-sm btn-danger" id="deselect-all">Limpar Seleção</button>
                        </div>
                        @php
                            // Extrai as descrições das permissões do usuário
                            $usuarioPermissoes = array_column($usuario['permissoes'] ?? [], 'descricao');
                        @endphp

                        <select name="permissoes[]" id="permissoes" class="form-select select2" multiple required
                            data-placeholder="Selecione permissões">
                            @foreach ($permissoes as $permission)
                                <option value="{{ $permission->name }}"
                                    @if (in_array($permission->name, old('permissoes', $usuarioPermissoes))) selected @endif>
                                    {{ $permission->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-primary w-50">
                        <i class="fas fa-save me-1"></i> Salvar Alterações
                    </button>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#select-all').click(function() {
                $('#permissoes option').prop('selected', true).trigger('change');
            });

            $('#deselect-all').click(function() {
                $('#permissoes option').prop('selected', false).trigger('change');
            });

            $('.select2').select2({
                width: '100%',
                placeholder: $('#permissoes').data('placeholder'),
                allowClear: true
            });
        });
    </script>
@stop
