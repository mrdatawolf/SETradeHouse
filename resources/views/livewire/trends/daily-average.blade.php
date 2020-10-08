<div>
    @foreach($trendDailyAvg as $title => $dailyAvg)
        @if(! in_array($title, ['scrap']))
            <div class="card">
                <div class="card-body">
                    <canvas id="trend{{ $title }}Daily"></canvas>
                </div>
            </div>

            <script>
                @php
                    $jsonDailyAvg       = json_encode($dailyAvg, true);
                    $jsonDailyAvgLabels = json_encode($trendDailyAvgLabels[$title]);
                @endphp
                var doc = document.getElementById('trend{{ $title }}Daily');
                if (doc != null) {
                    var ctx = doc.getContext('2d');
                    @if(empty($jsonDailyAvg) || empty($jsonDailyAvgLabels))
                        ctx.font = "30px Arial";
                        ctx.fillText("No data found", 10, 50);
                        console.log('No data found!');
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
            </script>
        @endif
    @endforeach
</div>
