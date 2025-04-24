@extends('adminlte::page')

@section('title', 'Gerenciar Empresa')

@section('content_header')
    <h1 class="text-dark">Gerenciar Empresa</h1>
    <hr>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('empresas.store') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <div class="input-group">
                        <label for="cnpj" class="col-md-3 label-control">* CNPJ:</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Digite o CNPJ" required>
                        </div>
                        <button class="btn btn-outline-primary" type="button" id="btnBuscarCnpj">
                            <i class="bi bi-search"></i> Buscar CNPJ
                        </button>
                    </div>
                </div>

                <div class="form-group row">
                        <label for="razao_social" class=" col-md-3 label-control">* Razão Social</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="razao_social" name="razao_social" placeholder="Razão Social" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="endereco" class="col-md-3 label-control">Endereço</label>
                    <div class="col-md-3">
                        <select class="form-control" id="endereco" name="endereco_id" required>
                            <option value="">Selecione um endereço</option>
                            @foreach ($enderecos ?? [] as $endereco)
                                <option value="{{ $endereco['id'] }}">{{ $endereco['logradouro'] }}, {{ $endereco['numero'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" class="btn bluebtn" data-bs-toggle="modal" data-bs-target="#modalEndereco">+ Novo</button>
                </div>

                <div class="card-footer">
                    <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Voltar</a>
                    <button type="submit" class="btn bluebtn">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para Criar Endereço -->
    <div class="modal fade" id="modalEndereco" tabindex="-1" aria-labelledby="modalEnderecoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalEnderecoLabel">Novo Endereço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEndereco">
                        <div class="mb-3">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" required>
                        </div>
                        <div class="mb-3">
                            <label for="logradouro" class="form-label">Logradouro</label>
                            <input type="text" class="form-control" id="logradouro" name="logradouro" required>
                        </div>
                        <div class="mb-3">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numero" name="numero" required>
                        </div>
                        <div class="mb-3">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" required>
                        </div>
                        <div class="mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" required>
                        </div>
                        <div class="mb-3">
                            <label for="uf" class="form-label">UF</label>
                            <input type="text" class="form-control" id="uf" name="uf" required>
                        </div>
                        <button type="button" class="btn btn-success w-100" id="salvarEndereco"
                            data-url="{{ route('enderecos.store') }}">Salvar Endereço</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }
        .btn-outline-primary {
            border-color: #1E3A5F;
            color: #1E3A5F;
        }
        .btn-outline-primary:hover {
            background-color: #1E3A5F;
            color: #fff;
        }
        .modal-header {
            background-color: #1E3A5F;
        }
        .modal-body {
            background-color: #f8f9fa;
        }
        .modal-title {
            font-size: 18px;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function () {
            // Máscaras de campos
            $('#cep').mask('00000-000');
            $('#cnpj').mask('00.000.000/0000-00');

            // Preenchendo campos de endereço automaticamente
            $('#cep').on('blur', function () {
                let cep = $(this).val().replace(/[^0-9]/g, '');
                if (cep.length == 8) {
                    $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function (data) {
                        if (!data.erro) {
                            $('#logradouro').val(data.logradouro);
                            $('#bairro').val(data.bairro);
                            $('#cidade').val(data.localidade);
                            $('#uf').val(data.uf);
                        } else {
                            alert('CEP não encontrado.');
                        }
                    }).fail(function () {
                        alert('Erro ao buscar o CEP.');
                    });
                }
            });

            // Salvando novo endereço
            $('#salvarEndereco').on('click', function () {
                let endereco = {
                    cep: $('#cep').val(),
                    logradouro: $('#logradouro').val(),
                    numero: $('#numero').val(),
                    bairro: $('#bairro').val(),
                    cidade: $('#cidade').val(),
                    uf: $('#uf').val()
                };
                var url = $('#salvarEndereco').data('url');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: endereco,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            // Cria a nova opção
                            const texto = `${endereco.logradouro}, ${endereco.numero}`;
                            const id = response.message.id;

                            // Adiciona ao select
                            $('#endereco').append(new Option(texto, id));

                            // Seleciona automaticamente o novo endereço
                            $('#endereco').val(id).trigger('change');

                            // Fecha o modal
                            $('#modalEndereco').modal('hide');
                        } else {
                            alert('Erro ao salvar o endereço.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Erro na requisição Ajax:', error);
                        alert('Erro na requisição Ajax.');
                    }
                });
            });

            // Função para buscar CNPJ
            $('#btnBuscarCnpj').on('click', function () {
                const cnpj = $('#cnpj').val().replace(/\D/g, ''); // Remove não-dígitos

                if (cnpj.length !== 14) {
                    alert('CNPJ inválido. Deve conter 14 dígitos.');
                    return;
                }

                fetch(`https://open.cnpja.com/office/${cnpj}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erro ao buscar CNPJ.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const razao = data.company?.name || 'Não encontrado';
                        $('#razao_social').val(razao);
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Erro ao buscar CNPJ. Verifique o console.');
                    });
            });
        });
    </script>
@endsection
