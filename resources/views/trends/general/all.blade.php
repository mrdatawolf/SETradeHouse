@extends('layouts.trend')
@section('pageTitle', 'Trends')

<style>

    .card {
        width: 20em;
        height: 11em;
        padding-bottom: 1em;
    }
</style>
@section('content')
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a href="#hourly_avg_prices" class="nav-link active" data-toggle="tab">Hourly Average Prices (last 24 hrs)</a>
        </li>
        <li class="nav-item">
            <a href="#daily_avg_prices" class="nav-link" data-toggle="tab">Daily Average Prices (last 30 days)</a>
        </li>
        <li class="nav-item">
            <a href="#daily_amount" class="nav-link" data-toggle="tab">Daily Amounts (last 30 days)</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="hourly_avg_prices">
            <div class="card-columns">
            @foreach($trendHourlyAvg as $title => $hourlyAvg)
                @if(! in_array($title, ['scrap']))
                    <div class="card">
                        <div class="card-body">
                            <canvas id="trend{{ $title }}Hourly"></canvas>
                        </div>
                    </div>
                @endif
            @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="daily_avg_prices">
            <div class="card-columns">
            @foreach($trendDailyAvg as $title => $dailyAvg)
                @if(! in_array($title, ['scrap']))
                    <div class="card">
                        <div class="card-body">
                            <canvas id="trend{{ $title }}Daily"></canvas>
                        </div>
                    </div>
                @endif
            @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="daily_amount">
            <div class="card-columns">
                @foreach($trendDailyAvg as $title => $dailyAvg)
                    @if(! in_array($title, ['scrap']))
                        <div class="card">
                            <div class="card-body">
                                <canvas id="trend{{ $title }}DailyAmount"></canvas>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
        @section('scripts')
            @parent
            <script>
                @foreach($trendHourlyAvg as $title => $hourlyAvg)
                @if(! in_array($title, ['scrap']))
                var canvasName = 'trend{{ $title }}Hourly';
                @php
                    $jsonHourlyAvg          = json_encode($hourlyAvg, true);
                    $jsonHourlyAvgLabels    = json_encode($trendHourlyAvgLabels[$title]);
                @endphp
                var doc = document.getElementById(canvasName);
                if (doc != null) {
                    var ctx = doc.getContext('2d');
                    @if(empty($jsonHourlyAvg) || empty($jsonHourlyAvgLabels))
                        ctx.font = "30px Arial";
                    ctx.fillText("No data found", 10, 50);
                    @else
                    var trend{{ $title }}Hourly = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: {!! $jsonHourlyAvgLabels !!},
                            datasets: [{
                                label: '{{ $title }}',
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
                    @endif
                }
                @endif
                @endforeach
            </script>
            <script>
                @foreach($trendDailyAvg as $title => $dailyAvg)
                @if(! in_array($title, ['scrap']))
                var canvasName = 'trend{{ $title }}Daily';
                @php
                    $jsonDailyAvg       = json_encode($dailyAvg, true);
                    $jsonDailyAvgLabels = json_encode($trendDailyAvgLabels[$title]);
                @endphp
                var doc = document.getElementById(canvasName);
                if (doc != null) {
                    var ctx = doc.getContext('2d');
                    @if(empty($jsonDailyAvg) || empty($jsonDailyAvgLabels))
                        ctx.font = "30px Arial";
                    ctx.fillText("No data found", 10, 50);
                    @else
                    var trend{{ $title }}Daily = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: {!! $jsonDailyAvgLabels !!},
                            datasets: [{
                                label: '{{ $title }}',
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
                    @endif
                }
                @endif
                @endforeach
            </script>
            <script>
                @foreach($trendDailyAvailable as $title => $dailyAvailable)

                @if(! in_array($title, ['scrap']))
                var canvasName = 'trend{{ $title }}DailyAmount';
                @php
                    $jsonDaily       = json_encode($dailyAvailable, true);
                    $jsonDailyLabels = json_encode($trendDailyAvgLabels[$title]);
                @endphp
                var doc = document.getElementById(canvasName);
                if (doc != null) {
                    var ctx = doc.getContext('2d');
                    @if(empty($jsonDaily) || empty($jsonDailyLabels))
                        ctx.font = "30px Arial";
                    ctx.fillText("No data found", 10, 50);
                    @else
                    var trend{{ $title }}DailyAmount = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: {!! $jsonDailyLabels !!},
                            datasets: [{
                                label: '{{ $title }}',
                                data: {!! $jsonDaily !!}
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
                    @endif
                }
                @endif
                @endforeach
            </script>
@endsection
