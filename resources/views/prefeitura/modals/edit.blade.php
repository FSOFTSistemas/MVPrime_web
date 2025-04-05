<!-- Modal Editar Prefeitura -->
<div class="modal fade" id="editPrefeituraModal{{ $prefeitura['id'] }}" tabindex="-1" role="dialog" aria-labelledby="editPrefeituraModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('prefeituras.update', $prefeitura['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">Editar Prefeitura</h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">CNPJ</label>
                        <input type="text" class="form-control" name="cnpj" value="{{ $prefeitura['cnpj'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Razão Social</label>
                        <input type="text" class="form-control" name="razao_social" value="{{ $prefeitura['razao_social'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Responsável</label>
                        <input type="text" class="form-control" name="responsavel" value="{{ $prefeitura['responsavel'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Endereço</label>
                        <select class="form-control select2" name="endereco_id" required>
                            @foreach ($enderecos as $endereco)
                                <option value="{{ $endereco['id'] }}" {{ $prefeitura['endereco_id'] == $endereco['id'] ? 'selected' : '' }}>
                                    {{ $endereco['logradouro'] }}, {{ $endereco['numero'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning text-white">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>