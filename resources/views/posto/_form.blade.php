@extends('adminlte::page')

@section('title', 'Cadastrar Posto')

@section('content_header')
    <h1>Novo Posto</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('postos.store') }}" method="POST" id="form-posto">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cnpj" class="form-label">CNPJ</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="cnpj" name="cnpj" required>
                            <button type="button" class="btn btn-outline-primary" id="btnBuscarCnpj">
                                🔍
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="responsavel" class="form-label">Responsável</label>
                        <input type="text" class="form-control" id="responsavel" name="responsavel" required>
                    </div>

                    <div class="col-md-5 mb-3">
                        <label for="endereco_id" class="form-label">Endereço</label>
                        <select class="form-control" id="endereco" name="endereco_id" required>
                            <option value="">Selecione um endereço</option>
                            @foreach ($enderecos as $endereco)
                                <option value="{{ $endereco['id'] }}">
                                    {{ $endereco['logradouro'] }}, {{ $endereco['numero'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1 mb-3 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-success w-100" data-toggle="modal"
                            data-target="#modalEndereco">+
                        </button>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="prefeitura_id" class="form-label">Prefeitura</label>
                        <select class="form-control w-100"  id="prefeitura" name="prefeitura_id" required>
                            <option value="">Selecione uma Prefeitura</option>
                            @foreach ($prefeituras as $prefeitura)
                                <option value="{{ $prefeitura['id'] }}">
                                    {{ $prefeitura['razao_social'] }}
                                </option>
                            @endforeach
                        </select>
                </div>

                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('postos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Salvar Posto</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para Criar Endereço -->
    <div class="modal fade" id="modalEndereco" tabindex="-1" aria-labelledby="modalEnderecoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
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
                            <label for="bairro" class="form-label">bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" required>
                        </div>
                        <div class="mb-3">
                            <label for="cidade" class="form-label">cidade</label>
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
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>


    <script>
        $(document).ready(function () {
            $('#cep').mask('00000-000');
            $('#cnpj').mask('00.000.000/0000-00');

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
                    url: url, // Certifique-se de que a rota está correta
                    type: 'POST',
                    data: endereco,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        console.log(response);
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
                        console.error('Status:', status);
                        alert('Erro na requisição Ajax.');
                    }
                });
            });

        });
    </script>

    <script>
        document.getElementById('btnBuscarCnpj').addEventListener('click', function () {
            const cnpj = document.getElementById('cnpj').value.replace(/\D/g, ''); // Remove não-dígitos

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
                    const nome = data.company?.name || 'Não encontrado';
                    document.getElementById('nome').value = nome;
                })
                .catch(error => {
                    console.error(error);
                    alert('Erro ao buscar CNPJ. Verifique o console.');
                });
        });
    </script>
@endsection