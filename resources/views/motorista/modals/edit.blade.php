<!-- Modal Editar Motorista -->
<div class="modal fade" id="editMotoristaModal{{ $motorista['id'] }}" tabindex="-1" role="dialog" aria-labelledby="editMotoristaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('motoristas.update', $motorista['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">Editar Motorista</h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" value="{{ $motorista['nome'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">CNH</label>
                        <input type="text" class="form-control" name="cnh" value="{{ $motorista['cnh'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vencimento CNH</label>
                        <input type="date" class="form-control" name="vencimento_cnh" value="{{'2025-06-09'}}" required>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Secretaria</label>
                        <select class="form-control select2" name="secretaria_id" required>
                            @foreach ($secretarias as $secretaria)
                            <option value="{{ $secretaria['id'] }}">
                                    {{ $secretaria['nome'] }}
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