@extends('layouts.app')
@section('pageTitle', 'Iron Trends')

@section('content')
    <div id="app" class="flex-center position-ref full-height">
<canvas id="trendIronHourly" width="50" height="50"></canvas>
<canvas id="trendIronDaily" width="10" height="10"></canvas>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        var ctx = document.getElementById('trendIronHourly').getContext('2d');
        var trendIronHourly = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! $jsonHourlyAvgLabels !!},
                datasets: [{
                    label: 'Average Price',
                    data: {!! $jsonHourlyAvg !!}
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: false
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        var ctx = document.getElementById('trendIronDaily').getContext('2d');
        var trendIronDaily = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! $jsonDailyAvgLabels !!},
                datasets: [{
                    label: 'Average Price',
                    data: {!! $jsonDailyAvg !!}
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: false
                        }
                    }]
                }
            }
        });
    </script>
@endsection
