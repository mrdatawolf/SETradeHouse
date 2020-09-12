@extends('layouts.trend')
@section('title', 'Oron Trends')

@section('content')
<canvas id="myChart" width="400" height="400"></canvas>
@endsection
@section('scripts')
    @parent
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! $jsonAvgLabels !!},
                datasets: [{
                    label: 'Average Price',
                    data: {!! $jsonAvg !!}
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endsection
