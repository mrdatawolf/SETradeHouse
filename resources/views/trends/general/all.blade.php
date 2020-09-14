@extends('layouts.trend')
@section('pageTitle', 'Trends')

<style>
    canvas{
        width:19em !important;
        height:10em !important;
    }
</style>
@section('content')
    @foreach($trendHourlyAvg as $title => $hourlyAvg)
        @if(! in_array($title, ['scrap']))
    <div class="row" style="padding-bottom: 1em">
        <div class="card-deck">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ ucfirst($title) }} Daily (last 30)</h5>
                    <canvas id="trend{{ $title }}Daily"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ ucfirst($title) }} Daily (last 30)</h5>
                    <canvas id="trend{{ $title }}DailyAmount"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ ucfirst($title) }} Hourly (last 24)</h5>
                    <canvas id="trend{{ $title }}Hourly"></canvas>
                </div>
            </div>
        </div>
    </div>
        @endif
    @endforeach
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
                if(doc != null) {
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
                if(doc != null) {
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
                                label: 'Average Price in transactions',
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
                    @endif
                }
            @endif
        @endforeach
    </script>
    <script>
        @foreach($trendDailyAvgAvailable as $title => $dailyAvg)
            @if(! in_array($title, ['scrap']))
                var canvasName = 'trend{{ $title }}DailyAmount';
                @php
                    $jsonDailyAvg       = json_encode($dailyAvg, true);
                    $jsonDailyAvgLabels = json_encode($trendDailyAvgLabels[$title]);
                @endphp
                var doc = document.getElementById(canvasName);
                if(doc != null) {
                    var ctx = doc.getContext('2d');
                    @if(empty($jsonDailyAvg) || empty($jsonDailyAvgLabels))
                        ctx.font = "30px Arial";
                    ctx.fillText("No data found", 10, 50);
                    @else
                    var trend{{ $title }}DailyAmount = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: {!! $jsonDailyAvgLabels !!},
                            datasets: [{
                                label: 'Amount in offer transactions',
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
                    @endif
                }
            @endif
        @endforeach
    </script>
@endsection
