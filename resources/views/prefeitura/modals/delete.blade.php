<!-- Modal Excluir Prefeitura -->
<div class="modal fade" id="deletePrefeituraModal{{ $prefeitura['id'] }}" tabindex="-1" role="dialog" aria-labelledby="deletePrefeituraModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('prefeituras.destroy', $prefeitura['id']) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Excluir Prefeitura</h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir a prefeitura <strong>{{ $prefeitura['razao_social'] }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>