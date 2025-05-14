@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')

<div class="alert alert-info alert-dismissible fade show position-relative top-3 end-0 mt-3" role="alert">
        <i class="fas fa-info-circle"></i> <strong>Aviso:</strong> Selecione a prefeitura desejada para visualizar os dados. Caso contrário, os dados serão exibidos para todas as prefeituras.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="row mt-3 col-md-12">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $totalPrefeituras }}</h3>

                <p>Prefeituras</p>
              </div>
              <div class="icon">
                <i class="fa fa-landmark"></i>
              </div>
            </div>
          </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $totalUsuarios }}</h3>

                <p>Usuários</p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
            </div>
          </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3> R${{ $totalAbastecimento }}</h3>

                <p>Abastecimentos Hoje</p>
              </div>
              <div class="icon">
                <i class="fa fa-gas-pump"></i>
              </div>
            </div>
          </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Abastecimentos por Mês</h3>
            </div>
            <div class="card-body chart-container">
                <canvas id="abastecimentosMes"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Abastecimentos por Dia - <span id="mes-atual"></span></h3>
            </div>
            <div class="card-body chart-container">
                <canvas id="abastecimentosDia"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Abastecimentos por Prefeitura</h3>
            </div>
            <div class="card-body chart-container">
                <canvas id="abastecimentosPrefeituras"></canvas>
            </div>
        </div>
    </div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const mesLabels = @json($mesLabels);
    const mesData = @json($mesData);

    const ctxAbastecimentos = document.getElementById('abastecimentosMes').getContext('2d');
    const abastecimentoChart = new Chart(ctxAbastecimentos, {
        type: 'bar',
        data: {
            labels: mesLabels,
            datasets: [{
                label: 'Valores (R$)',
                data: mesData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 1,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script>
    const diaLabels = @json($diaLabels);
    const diaData = @json($diaData);

    const ctxAbastecimentosDia = document.getElementById('abastecimentosDia').getContext('2d');
    const abastecimentoDiaChart = new Chart(ctxAbastecimentosDia, {
        type: 'line',
        data: {
            labels: diaLabels,
            datasets: [{
                label: 'Valor (R$)',
                data: diaData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 1,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script>
    const dados = @json($dadosPrefeitura);

    function formatarMes(anoMes) {
        const [ano, mes] = anoMes.split('-');
        const nomesMeses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        return `${nomesMeses[parseInt(mes) - 1]}/${ano}`;
    }

    const mesesOriginais = [...new Set(dados.map(item => item.mes))].sort();
    const mesesFormatados = mesesOriginais.map(formatarMes);
    const prefeituras = [...new Set(dados.map(item => item.prefeitura_nome))];

    function randomColor() {
        const r = Math.floor(Math.random() * 255);
        const g = Math.floor(Math.random() * 255);
        const b = Math.floor(Math.random() * 255);
        return `rgba(${r}, ${g}, ${b}, 1)`;
    }

    const datasets = prefeituras.map(prefeitura => {
        const cor = randomColor();
        return {
            label: prefeitura,
            data: mesesOriginais.map(mesOriginal => {
                const registro = dados.find(d => d.mes === mesOriginal && d.prefeitura_nome === prefeitura);
                return registro ? registro.total_valor : 0;
            }),
            borderColor: cor,
            backgroundColor: cor,
            fill: false,
            tension: 0.4
        };
    });

    const ctx = document.getElementById('abastecimentosPrefeituras').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: mesesFormatados,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>



<script>
    const meses = [
  "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
  "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
];

const dataAtual = new Date();
const mesAtual = meses[dataAtual.getMonth()];

document.getElementById("mes-atual").textContent = mesAtual;
</script>
@stop

@section('css')
    <style>
    .card-header {
        background-color: var(--blue-1) !important;
        color: #fff !important;
    }

    .content-wrapper {
        min-height: 100vh;
        overflow-x: hidden;
        height: auto !important;
    }

    .card-body {
    position: relative;
    height: 300px;
}

    .card-body canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
    }
</style>
