@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')

<div class="row mt-3">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>10</h3>
    
            <p>Veículos</p>
          </div>
          <div class="icon">
            <i class="fa fa-car"></i>
          </div>
        </div>
      </div> 

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>14</h3>
    
            <p>Motoristas</p>
          </div>
          <div class="icon">
            <i class="fa fa-users"></i>
          </div>
        </div>
      </div>    

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>R$ 1457</h3>
    
            <p>Abastecimentos no mês</p>
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
                <h3 class="card-title">Abastecimentos por Secretaria</h3>
            </div>
            <div class="card-body chart-container">
                <canvas id="abastecimentosMes"></canvas>
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