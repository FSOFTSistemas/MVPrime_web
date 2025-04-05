<!-- Modal Editar -->
<div class="modal fade" id="editEmpresaModal{{ $empresa['id'] }}" tabindex="-1" aria-labelledby="editEmpresaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmpresaModalLabel">Editar Empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('empresas.update', $empresa['id']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="cnpj" class="form-label">CNPJ</label>
                        <input type="text" class="form-control" name="cnpj" value="{{ $empresa['cnpj'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="razao_social" class="form-label">Razão Social</label>
                        <input type="text" class="form-control" name="razao_social"
                            value="{{ $empresa['razao_social'] }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço</label>
                        <div class="input-group">
                            <select class="form-control" id="endereco" name="endereco_id" required>
                                <option value="">Selecione um endereço</option>
                                @foreach ($enderecos ?? [] as $endereco)
                                    <option value="{{ $endereco['id'] }}" @if (old('endereco_id', $empresa['endereco_id'] ?? '') == $endereco['id']) selected @endif>
                                        {{ $endereco['logradouro'] }}, {{ $endereco['numero'] }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                data-target="#modalEndereco" title="Novo endereço">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
</div>
</div>