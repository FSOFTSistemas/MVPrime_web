<!-- Modal Excluir -->
<div class="modal fade" id="deleteEmpresaModal{{ $empresa['id'] }}" tabindex="-1" aria-labelledby="deleteEmpresaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteEmpresaModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir a empresa <strong>{{ $empresa['razao_social'] }}</strong>?</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('empresas.destroy', $empresa['id']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>