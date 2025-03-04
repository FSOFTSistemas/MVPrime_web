<div class="modal fade" id="deleteUsuarioModal{{ $usuario['id'] }}" tabindex="-1" aria-labelledby="deleteUsuarioModalLabel{{ $usuario['id'] }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUsuarioModalLabel{{ $usuario['id'] }}">Excluir Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Você tem certeza de que deseja excluir o usuário <strong>{{ $usuario['nome'] }}</strong>?</p>
                <p><strong>Este processo é irreversível.</strong></p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('usuarios.destroy', $usuario['id']) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>