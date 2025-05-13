@extends('adminlte::page')

@section('title', 'Gerenciar Empresa')

@section('content_header')
    <h1 class="text-dark">Gerenciar Empresa</h1>
    <hr>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ isset($empresas) ? route('empresas.update', $empresas['id']) : route('empresas.store') }}"
                method="POST">
                @csrf
                @if (isset($empresas))
                    @method('PUT')
                @endif
                <div class="form-group row">
                    <div class="input-group">
                        <label for="cnpj" class="col-md-3 label-control">* CNPJ:</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="cnpj" name="cnpj"
                                placeholder="Digite o CNPJ" required value="{{ old('cnpj', $empresas['cnpj'] ?? '') }}">

                        </div>
                        <button class="btn btn-outline-primary" type="button" id="btnBuscarCnpj">
                            <i class="bi bi-search"></i> Buscar CNPJ
                        </button>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="razao_social" class=" col-md-3 label-control">* Razão Social</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="razao_social" name="razao_social"
                            placeholder="Razão Social" required
                            value="{{ old('razao_social', $empresas['razao_social'] ?? '') }}">

                    </div>
                </div>

                <div class="card-footer text-center">
                        <button type="submit" class="btn new btn-success mt-2 btn-save w-50">Salvar</button>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

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
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            // Máscaras de campos
            $('#cep').mask('00000-000');
            $('#cnpj').mask('00.000.000/0000-00');

            // Preenchendo campos de endereço automaticamente
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

            // Função para buscar CNPJ
            $('#btnBuscarCnpj').on('click', function() {
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

    <script>
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                form.querySelectorAll('input').forEach(input => input.removeAttribute('readonly'));
                form.querySelector('.btn-save').classList.remove('d-none');
                this.classList.add('d-none');
            });
        });
    </script>

@endsection
