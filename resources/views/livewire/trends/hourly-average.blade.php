<div>
    @foreach($trendHourlyAvg as $title => $hourlyAvg)
        @if(! in_array($title, ['scrap']))
            <div class="card">
                <div class="card-body">
                    <canvas id="trend{{ $title }}Hourly"></canvas>
                </div>
            </div>

            <script>
                @php
                    $jsonHourlyAvg          = json_encode($hourlyAvg, true);
                    $jsonHourlyAvgLabels    = json_encode($trendHourlyAvgLabels[$title]);
                @endphp
                var doc = document.getElementById('trend{{ $title }}Hourly');
                if (doc != null) {
                    var ctx = doc.getContext('2d');
                    @if(empty($jsonHourlyAvg) || empty($jsonHourlyAvgLabels))
                        ctx.font = "30px Arial";
                        ctx.fillText("No data found", 10, 50);
                        console.log('No data found!');
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
            </script>
        @endif
    @endforeach
</div>


