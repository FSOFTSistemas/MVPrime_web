<!-- Modal Editar Veiculo -->
<div class="modal fade" id="editVeiculoModal{{ $veiculo['id'] }}" tabindex="-1" role="dialog" aria-labelledby="editVeiculoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('veiculos.update', $veiculo['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">Editar Veiculo</h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Modelo</label>
                        <input type="text" class="form-control" name="modelo" value="{{ $veiculo['modelo'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ano</label>
                        <input type="text" class="form-control" name="ano" value="{{ $veiculo['ano'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Qtd de litros máxima</label>
                        <input type="text" class="form-control" name="quantidade_litros" value="{{$veiculo['quantidade_litros']}}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Qtd de abastecimentos</label>
                        <input type="text" class="form-control" name="quantidade_abastecimentos" value="{{ $veiculo['quantidade_abastecimentos'] }}" required>
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Período de limite</label>
                    <select class="form-control" name="limite_abastecimento_periodo" required>
                        <option value="1" {{ $veiculo['limite_abastecimento_periodo'] == 1 ? 'selected' : '' }}>Dia</option>
                        <option value="2" {{ $veiculo['limite_abastecimento_periodo'] == 2 ? 'selected' : '' }}>Semana</option>
                        <option value="3" {{ $veiculo['limite_abastecimento_periodo'] == 3 ? 'selected' : '' }}>Mês</option>
                    </select>
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