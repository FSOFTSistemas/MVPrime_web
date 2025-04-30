@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
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

@stop

@section('js')
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
        color: #fff;
    }

    .content-wrapper {
        min-height: 100vh;
        overflow-x: hidden;
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