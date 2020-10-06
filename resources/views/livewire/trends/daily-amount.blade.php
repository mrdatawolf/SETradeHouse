<div>
    @foreach($trendDailyAvailable as $title => $dailyAvailable)
        @if(! in_array($title, ['scrap']))
            <div class="card">
                <div class="card-body">
                    <canvas id="trend{{ $title }}DailyAmount"></canvas>
                </div>
            </div>

            <script>
            @php
                $jsonDaily       = json_encode($dailyAvailable, true);
                $jsonDailyLabels = json_encode($trendDailyAvgLabels[$title]);
            @endphp
            var doc = document.getElementById('trend{{ $title }}DailyAmount');
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
            </script>
        @endif
    @endforeach
</div>
