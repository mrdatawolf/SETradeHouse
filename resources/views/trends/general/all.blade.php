@extends('layouts.trend')
@section('pageTitle', 'Trends')

<style>
    canvas{
        width:30em !important;
        height:10em !important;
    }
</style>
@section('content')
    @foreach($trendHourlyAvg as $title => $hourlyAvg)
    <div class="row" style="padding-bottom: 1em">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ ucfirst($title) }} Daily (last 30)</h5>
                    <canvas id="trend{{ $title }}Daily"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ ucfirst($title) }} Hourly (last 30)</h5>
                    <canvas id="trend{{ $title }}Hourly"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection
@section('scripts')
    @parent
    <script>
        @foreach($trendHourlyAvg as $title => $hourlyAvg)
            @php
            $jsonHourlyAvg          = json_encode($hourlyAvg, true);
            $jsonHourlyAvgLabels    = json_encode($trendHourlyAvgLabels[$title]);
            @endphp
            var ctx = document.getElementById('trend{{ $title }}Hourly').getContext('2d');
            var trend{{ $title }}Hourly = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! $jsonHourlyAvgLabels !!},
                    datasets: [{
                        label: 'Average Price',
                        data: {!! $jsonHourlyAvg !!}
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: false
                            }
                        }]
                    }
                }
            });
        @endforeach
    </script>
    <script>
        @foreach($trendDailyAvg as $title => $dailyAvg)
            @php
                $jsonDailyAvg       = json_encode($dailyAvg, true);
                $jsonDailyAvgLabels = json_encode($trendDailyAvgLabels[$title]);
            @endphp
            var ctx = document.getElementById('trend{{ $title }}Daily').getContext('2d');
            var trend{{ $title }}Daily = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! $jsonDailyAvgLabels !!},
                    datasets: [{
                        label: 'Average Price',
                        data: {!! $jsonDailyAvg !!}
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: false
                            }
                        }]
                    }
                }
            });
        @endforeach
    </script>
@endsection
