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
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                        <label class="form-label">Data de abastecimento</label>
                        <input type="datetime-local" class="form-control" name="data_abastecimento"value="{{ Carbon::parse($abastecimento['data_abastecimento'])->format('Y-m-d\TH:i:s') }}"step="1" required>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Veículo</label>
                            <select class="form-control select2" name="veiculo_id" required>
                                @foreach ($veiculos ?? [] as $veiculo)
                                <option value="{{ $veiculo['id'] }}" {{ $abastecimento['veiculo_id'] == $veiculo['id'] ? 'selected' : '' }}>
                                        {{ $veiculo['placa'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Motorista</label>
                            <select class="form-control select2" name="motorista_id" required>
                                <option value="">Selecione o motorista</option>
                                @foreach ($motoristas ?? [] as $motorista)
                                    <option value="{{ $motorista['id'] }}" {{ $abastecimento['motorista_id'] == $motorista['id'] ? 'selected' : '' }}>
                                        {{ $motorista['nome'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Posto</label>
                            <select class="form-control select2" name="posto_id" required>
                                @foreach ($postos ?? [] as $posto)
                                <option value="{{ $posto['id'] }}" {{ $abastecimento['posto_id'] == $posto['id'] ? 'selected' : '' }}>
                                        {{ $posto['nome'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tipo de Combustível</label>
                            <select class="form-control" name="tipo_combustivel" required>
                                <option value="Gasolina" {{ $abastecimento['tipo_combustivel'] == 'Gasolina' ? 'selected' : '' }}>Gasolina</option>
                                <option value="Gasolina Aditivada" {{ $abastecimento['tipo_combustivel'] == 'Gasolina Aditivada' ? 'selected' : '' }}>Gasolina Aditivada</option>
                                <option value="Etanol" {{ $abastecimento['tipo_combustivel'] == 'Etanol' ? 'selected' : '' }}>Etanol</option>
                                <option value="Diesel" {{ $abastecimento['tipo_combustivel'] == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label class="form-label">Secretaria</label>
                            <select class="form-control select2" name="secretaria_id" required>
                                @foreach ($secretarias ?? [] as $secretaria)
                                <option value="{{ $secretaria['id'] }}" {{ $abastecimento['secretaria_id'] == $secretaria['id'] ? 'selected' : '' }}>
                                        {{ $secretaria['nome'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Km Atual</label>
                            <input type="text" class="form-control" name="km_atual" value="{{ $abastecimento['km_atual'] }}" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Média KM/L</label>
                            <input type="text" class="form-control" name="media_km_litro" value="{{ $abastecimento['media_km_litro'] }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Preço do litro</label>
                            <input type="text" class="form-control" name="preco_combustivel" value="{{ number_format($abastecimento['preco_combustivel'], 2, ',', '.') }}" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Valor Total</label>
                            <input type="text" class="form-control" name="valor" value="{{ number_format($abastecimento['valor'], 2, ',', '.') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning text-white">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>