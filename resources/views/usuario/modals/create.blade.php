<div class="modal fade" id="createUsuarioModal" tabindex="-1" aria-labelledby="createUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUsuarioModalLabel">Criar Novo Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulário de criação de usuário -->
                <form method="POST" action="{{ route('usuarios.store') }}">
                    @csrf
                    <!-- Campos do formulário -->
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="permissoes" class="form-label">Permissões</label>
                        <select class="form-select" id="permissoes" name="permissoes[]" multiple required>
                            @foreach ($permissoes as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Criar</button>
                </form>
            </div>
        </div>
    </div>
</div>
