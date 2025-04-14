<?php
use Carbon\Carbon;
?>

<!-- Modal Editar Abastecimento -->
<div class="modal fade" id="editAbastecimentoModal{{ $abastecimento['id'] }}" tabindex="-1" role="dialog" aria-labelledby="editAbastecimentoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('abastecimentos.update', $abastecimento['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white">Editar Abastecimento</h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                        <label class="form-label">Data de abastecimento</label>
                        <input type="datetime-local" class="form-control" name="data_abastecimento"value="{{ Carbon::parse($abastecimento['data_abastecimento'])->format('Y-m-d\TH:i:s') }}"step="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Veículo</label>
                        <input type="text" class="form-control" name="veiculo" value="{{ $abastecimento['veiculo']['placa'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Motorista</label>
                        <input type="text" class="form-control" name="motorista" value="{{ $abastecimento['motorista']['nome'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Posto</label>
                        <input type="text" class="form-control" name="posto" value="{{ $abastecimento['posto']['nome'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Combustível</label>
                        <input type="text" class="form-control" name="combustivel" value="{{ $abastecimento['tipo_combustivel'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Km Atual</label>
                        <input type="text" class="form-control" name="km_atual" value="{{ $abastecimento['km_atual'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Média KM/L</label>
                        <input type="text" class="form-control" name="media_km_litro" value="{{ $abastecimento['media_km_litro'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Litros</label>
                        <input type="text" class="form-control" name="litros" value="{{ $abastecimento['valor']/$abastecimento['preco_combustivel'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Preço do litro</label>
                        <input type="text" class="form-control" name="preco_combustivel" value="{{ number_format($abastecimento['preco_combustivel'], 2, ',', '.') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Valor Total</label>
                        <input type="text" class="form-control" name="valor" value="{{ number_format($abastecimento['valor'], 2, ',', '.') }}" required>
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