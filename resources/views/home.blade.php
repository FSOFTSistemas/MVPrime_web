@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    {{-- <div class="card">
        <div class="card-header">Abastecimentos por Prefeitura</div>
        <div class="card-body">
            <canvas id="graficoAbastecimento"></canvas>
        </div>
    </div> --}}
@stop

@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const ctx = document.getElementById('graficoAbastecimento').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Quantidade de Abastecimentos',
                data: @json($valores),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script> --}}
@stop
