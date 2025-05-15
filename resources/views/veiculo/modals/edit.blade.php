<!-- Modal Editar Veiculo -->
<div class="modal fade" id="editVeiculoModal{{ $veiculo['id'] }}" tabindex="-1" role="dialog"
    aria-labelledby="editVeiculoModalLabel" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('veiculos.update', $veiculo['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">Editar Veiculo</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Modelo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="modelo" value="{{ $veiculo['modelo'] }}"
                            required pattern="[A-Za-zÀ-ÿ0-9\s]{3,}"
                            title="Use apenas letras e números, mínimo de 3 caracteres">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ano <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="ano" name="ano" required min="1960"
                            max="{{ date('Y') + 1 }}" step="1" placeholder="Ex: 2024">
                        @error('ano')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Qtd de litros máxima <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="quantidade_litros"
                            value="{{ $veiculo['quantidade_litros'] }}" min="1" max="650" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Qtd de abastecimentos <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="quantidade_abastecimentos"
                            value="{{ $veiculo['quantidade_abastecimentos'] }}" min="1" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Período de limite <span class="text-danger">*</span></label>
                        <select class="form-control" name="limite_abastecimento_periodo" required>
                            <option value="1" {{ $veiculo['limite_abastecimento_periodo'] == 1 ? 'selected' : '' }}>Dia</option>
                            <option value="2" {{ $veiculo['limite_abastecimento_periodo'] == 2 ? 'selected' : '' }}>Semana</option>
                            <option value="3" {{ $veiculo['limite_abastecimento_periodo'] == 3 ? 'selected' : '' }}>Mês</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Secretaria <span class="text-danger">*</span></label>
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
                    <button type="submit" class="btn btn-warning text-white w-100">Salvar / Sair</button>
                </div>
            </form>
        </div>
    </div>
</div>
