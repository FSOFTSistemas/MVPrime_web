<!-- Modal Editar Abastecimento -->
<div class="modal fade" id="editAbastecimentoModal{{ $abastecimento['id'] }}" tabindex="-1" role="dialog" aria-labelledby="editAbastecimentoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('abastecimentos.update', $abastecimento['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">Editar Abastecimento</h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" value="{{ $abastecimento['id'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">CNH</label>
                        <input type="text" class="form-control" name="cnh" value="{{ $abastecimento['id'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vencimento CNH</label>
                        <input type="date" class="form-control" name="vencimento_cnh" value="{{$abastecimento['id']}}" required>
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