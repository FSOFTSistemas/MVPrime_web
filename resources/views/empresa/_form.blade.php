@extends('adminlte::page')

@section('title', 'Gerenciar Empresa')

@section('content_header')
    <h1>Gerenciar Empresa</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('empresas.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="razao_social" class="form-label">Razão Social</label>
                    <input type="text" class="form-control" id="razao_social" name="razao_social" required>
                </div>

                <div class="mb-3">
                    <label for="cnpj" class="form-label">CNPJ</label>
                    <input type="text" class="form-control" id="cnpj" name="cnpj" required>
                </div>

                <div class="mb-3">
                    <label for="endereco" class="form-label">Endereço</label>
                    <div class="input-group">
                        <select class="form-control" id="endereco" name="endereco_id" required>
                            <option value="">Selecione um endereço</option>
                            @foreach ($enderecos ?? [] as $endereco)
                                <option value="{{ $endereco['id'] }}">{{ $endereco['logradouro'] }},
                                    {{ $endereco['numero'] }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEndereco">+
                            Novo</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Salvar</button>
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
                        <button type="button" class="btn btn-success w-100" id="salvarEndereco">Salvar Endereço</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#cep').mask('00000-000');
            $('#cnpj').mask('00.000.000/0000-00');

            $('#cep').on('blur', function() {
                let cep = $(this).val().replace(/[^0-9]/g, '');
                if (cep.length == 8) {
                    $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                        if (!data.erro) {
                            $('#logradouro').val(data.logradouro);
                            $('#bairro').val(data.bairro);
                            $('#cidade').val(data.localidade);
                            $('#uf').val(data.uf);
                        } else {
                            alert('CEP não encontrado.');
                        }
                    }).fail(function() {
                        alert('Erro ao buscar o CEP.');
                    });
                }
            });

            $('#salvarEndereco').on('click', function() {
                let endereco = {
                    cep: $('#cep').val(),
                    logradouro: $('#logradouro').val(),
                    numero: $('#numero').val(),
                    bairro: $('#bairro').val(),
                    cidade: $('#cidade').val(),
                    uf: $('#uf').val()
                };

                $.ajax({
                    url: '{{ route('enderecos.store') }}', // Certifique-se de que a rota está correta
                    type: 'POST',
                    data: endereco,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.success) {
                            // Adiciona o endereço ao select
                            $('#endereco').append(new Option(
                                `${endereco.logradouro}, ${endereco.numero}`, response
                                .id));
                            $('#modalEndereco').modal('hide');
                        } else {
                            alert('Erro ao salvar o endereço.');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Mostra o erro detalhado no console para debug
                        console.error('Erro na requisição Ajax:', error);
                        alert('Erro na requisição Ajax.');
                    }
                });
            });

        });
    </script>
@endsection
