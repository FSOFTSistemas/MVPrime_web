<!-- Modal Editar Posto -->
<div class="modal fade" id="editPostoModal{{ $posto['id'] }}" tabindex="-1" role="dialog" aria-labelledby="editPostoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('postos.update', $posto['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">Editar Posto</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">CNPJ</label>
                        <input type="text" class="form-control" name="cnpj" value="{{ $posto['cnpj'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Razão Social</label>
                        <input type="text" class="form-control" name="nome" value="{{ $posto['nome'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Responsável</label>
                        <input type="text" class="form-control" name="responsavel" value="{{ $posto['responsavel'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Endereço</label>
                        <select class="form-control select2" name="endereco_id" required>
                            @foreach ($enderecos as $endereco)
                                <option value="{{ $endereco['id'] }}" {{ $posto['endereco_id'] == $endereco['id'] ? 'selected' : '' }}>
                                    {{ $endereco['logradouro'] }}, {{ $endereco['numero'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning text-white">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>