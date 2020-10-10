<div>
    @foreach($trendHourlyAvailable as $title => $hourlyAvailable)
        @if(! in_array($title, ['scrap']))
            <div class="card">
                <div class="card-body">
                    <canvas id="trend{{ $title }}HourlyAmount"></canvas>
                </div>
            </div>

            <script>
                @php
                    $jsonHourly          = json_encode($hourlyAvailable, true);
                    $jsonHourlyLabels    = json_encode($trendHourlyLabels[$title]);
                @endphp
                var doc = document.getElementById('trend{{ $title }}HourlyAmount');
                if (doc != null) {
                    var ctx = doc.getContext('2d');
                    @if(empty($jsonHourly) || empty($jsonHourlyLabels))
                        ctx.font = "30px Arial";
                    ctx.fillText("No data found", 10, 50);
                    console.log('No data found!');
                    @else
                    var trend{{ $title }}HourlyAmount = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: {!! $jsonHourlyLabels !!},
                            datasets: [{
                                label: '{{ $title }}',
                                data: {!! $jsonHourly !!}
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


