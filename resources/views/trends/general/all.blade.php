@extends('layouts.app')
@section('pageTitle', 'Trends')

<style>
    .card {
        width: 20em;
        height: 20em;
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
                @livewire('trends.hourly-average', ['trendHourlyAvg' => $trendHourlyAvg, 'trendHourlyAvgLabels' => $trendHourlyAvgLabels])
            </div>
        </div>
        <div class="tab-pane fade" id="daily_avg_prices">
            <div class="card-columns">
                @livewire('trends.daily-average', ['trendDailyAvg' => $trendDailyAvg, 'trendDailyAvgLabels' => $trendDailyAvgLabels])
            </div>
        </div>
        <div class="tab-pane fade" id="daily_amount">
            <div class="card-columns">
                @livewire('trends.daily-amount', ['trendDailyAvailable' => $trendDailyAvailable, 'trendDailyAvgLabels' => $trendDailyAvgLabels])
            </div>
        </div>
    </div>
@endsection
