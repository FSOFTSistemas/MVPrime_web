<div class="modal fade" id="modalNovoEndereco" tabindex="-1" aria-labelledby="modalNovoEnderecoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formNovoEndereco">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalNovoEnderecoLabel">Novo Endereço</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="logradouro" class="form-label">Logradouro</label>
                        <input type="text" class="form-control" id="logradouro" name="logradouro" required>
                    </div>
                    <div class="mb-3">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero" name="numero" required>
                    </div>
                    <div class="mb-3">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro" required>
                    </div>
                    <div class="mb-3">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Salvar Endereço</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $('#formNovoEndereco').submit(function (e) {
        e.preventDefault();

        const dados = {
            logradouro: $('#logradouro').val(),
            numero: $('#numero').val(),
            bairro: $('#bairro').val(),
            cidade: $('#cidade').val(),
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: "{{ route('enderecos.store') }}",
            method: 'POST',
            data: dados,
            success: function (response) {
                if (response.success && response.endereco) {
                    const novoEndereco = response.endereco;
                    const texto = `${novoEndereco.logradouro}, ${novoEndereco.numero}`;

                    $('#endereco_id').append(new Option(texto, novoEndereco.id, true, true));
                    $('#modalNovoEndereco').modal('hide');
                    $('#formNovoEndereco')[0].reset();
                } else {
                    alert('Erro ao salvar endereço.');
                }
            },
            error: function () {
                alert('Erro no servidor ao salvar endereço.');
            }
        });
    });
</script>
