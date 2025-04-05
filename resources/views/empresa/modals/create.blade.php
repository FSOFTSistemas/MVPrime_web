<!-- Modal Criar/Editar Empresa -->
<div class="modal fade" id="createUpdateEmpresaModal" tabindex="-1" aria-labelledby="createUpdateEmpresaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUpdateEmpresaModalLabel">
                    @isset($empresa)
                        Editar Empresa
                    @else
                        Criar Nova Empresa
                    @endisset
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ isset($empresa) ? route('empresas.update', $empresa['id']) : route('empresas.store') }}" method="POST">
                    @csrf
                    @isset($empresa)
                        @method('PUT')
                    @endisset

                    <div class="mb-3">
                        <label for="razao_social" class="form-label">Razão Social</label>
                        <input type="text" class="form-control" id="razao_social" name="razao_social" value="{{ $empresa['razao_social'] ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="cnpj" class="form-label">CNPJ</label>
                        <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ $empresa['cnpj'] ?? '' }}" required>
                    </div>

                    <!-- Campo de Endereço -->
                    <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço</label>
                        <div class="input-group">
                            <select class="form-select" id="endereco" name="endereco_id" required>
                                <option value="">Selecione um endereço</option>
                                @foreach ($enderecos ?? [] as $endereco)
                                    <option value="{{ $endereco['id'] }}" {{ (isset($empresa) && $empresa['endereco_id'] == $endereco['id']) ? 'selected' : '' }}>
                                        {{ $endereco['rua'] }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#createEnderecoModal">
                                + Novo Endereço
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">
                            @isset($empresa)
                                Atualizar
                            @else
                                Criar
                            @endisset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Criar Endereço -->
<div class="modal fade" id="createEnderecoModal" tabindex="-1" aria-labelledby="createEnderecoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEnderecoModalLabel">Cadastrar Endereço</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('enderecos.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="rua" class="form-label">Rua</label>
                        <input type="text" class="form-control" id="rua" name="rua" required>
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
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep" required>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>