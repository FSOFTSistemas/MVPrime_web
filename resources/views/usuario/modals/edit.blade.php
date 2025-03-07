<div class="modal fade" id="editUsuarioModal{{ $usuario['id'] }}" tabindex="-1" aria-labelledby="editUsuarioModalLabel{{ $usuario['id'] }}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUsuarioModalLabel{{ $usuario['id'] }}">Editar Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulário de edição de usuário -->
                <form method="POST" action="{{ route('usuarios.update', $usuario['id']) }}">
                    @csrf
                    @method('PUT')
                    <!-- Campos do formulário -->
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="{{ $usuario['nome'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $usuario['email'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <div class="mb-3">
                        <label for="permissoes" class="form-label">Permissões</label>
                        <select class="form-select" id="permissoes" name="permissoes[]" multiple required>
                            @foreach ($permissoes as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>