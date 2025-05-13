@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')

    <div class="row mt-3">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
            <div class="inner">
                <h3> R${{ $totalAbastecimentosHoje }}</h3>
        
                <p>Abastecimentos no dia</p>
            </div>
            <div class="icon">
                <i class="fa fa-gas-pump"></i>
            </div>
            </div>
        </div> 

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
            <div class="inner">
                <h3> R${{ $abastecimentosMesAtual }}</h3>
        
                <p>Abastecimentos nesse mês</p>
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
                <h3 class="card-title">Abastecimentos por Tipo de combustível - <span id="mes-atual"></span></h3>
            </div>
            <div class="card-body chart-container">
                <canvas id="abastecimentosPorCombustivel"></canvas>
            </div>
        </div>
    </div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    console.log("abastecimentos aqui")
    const dadosMensais = @json($totalAbastecimentosMes);

    const labels = dadosMensais.map(item => item.mes);
    const valores = dadosMensais.map(item => parseFloat(item.total_valor));

    const ctx = document.getElementById('abastecimentosMes').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Valor Total por Mês (R$)',
                data: valores,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'R$'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mês'
                    }
                }
            }
        }
    });
</script>

<script>
    console.log("combustivel aqui")
    const combustivel = @json($combustivel);
    const labelsComb = combustivel.map(item => item.tipo_combustivel);
    const valoresComb = combustivel.map(item => Number(item.total_valor))
    const ctxComb = document.getElementById('abastecimentosPorCombustivel').getContext('2d');
    new Chart(ctxComb, {
      type: 'pie',
      data: {
        labels: labelsComb,
        datasets: [{
          label: 'Valor por Combustível (Mês Atual) R$',
          data: valoresComb,
          backgroundColor: [
            '#4CAF50', '#2196F3', '#FFC107', '#F44336', '#9C27B0' 
          ],
          borderWidth: 3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top'
          },
          title: {
            display: true,
            text: 'Distribuição de Abastecimento por Combustível'
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
        height: auto !important;
    }

    .card-body {
    position: relative;
    height: 400px;
}

    .card-body canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
    }
</style>