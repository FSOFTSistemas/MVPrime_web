<!-- Modal Excluir Motorista -->
<div class="modal fade" id="deleteMotoristaModal{{ $motorista['id'] }}" tabindex="-1" role="dialog" aria-labelledby="deleteMotoristaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('motoristas.destroy', $motorista['id']) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Excluir Motorista</h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir a motorista <strong>{{ $motorista['nome'] }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </div>
            </form>
        </div>
    </div>
</div>