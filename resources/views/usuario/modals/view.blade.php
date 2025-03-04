<div class="modal fade" id="viewUsuarioModal{{ $usuario['id'] }}" tabindex="-1" aria-labelledby="viewUsuarioModalLabel{{ $usuario['id'] }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUsuarioModalLabel{{ $usuario['id'] }}">Visualizar Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Exibe os detalhes do usuário -->
                <p><strong>Nome:</strong> {{ $usuario['nome'] }}</p>
                <p><strong>Email:</strong> {{ $usuario['email'] }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>