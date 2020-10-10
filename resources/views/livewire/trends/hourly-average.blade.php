<div>
    @foreach($trendHourlyAvg as $title => $hourlyAvg)
        @if(! in_array($title, ['scrap']))
            <div class="card">
                <div class="card-body">
                    <canvas id="trend{{ $title }}HourlyAverage"></canvas>
                </div>
            </div>

            <script>
                @php
                    $jsonHourlyAvg          = json_encode($hourlyAvg, true);
                    $jsonHourlyLabels    = json_encode($trendHourlyLabels[$title]);
                @endphp
                var doc = document.getElementById('trend{{ $title }}HourlyAverage');
                if (doc != null) {
                    var ctx = doc.getContext('2d');
                    @if(empty($jsonHourlyAvg) || empty($jsonHourlyLabels))
                        ctx.font = "30px Arial";
                        ctx.fillText("No data found", 10, 50);
                        console.log('No data found!');
                    @else
                    var trend{{ $title }}HourlyAverage = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: {!! $jsonHourlyLabels !!},
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


