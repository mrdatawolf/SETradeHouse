<link href="{{ asset('css/ticker.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery.ticker.js') }}"></script>
<nav id="tickerBlock" class="navbar navbar-light bg-white shadow-sm fixed-bottom">
    <div class="ticker">
        <strong>Commodity Values:</strong>
        <ul>
            @php
            $stockLevels = \Session::get('stockLevels');
            $tickerData = [];
            if(! empty($stockLevels)) {
                foreach($stockLevels as $type => $data) {
                    $count = 0;
                    $stringedData = $type."...";
                    foreach($data as $name => $value) {
                        if($count > 7) {
                            $tickerData[] = $stringedData;
                            $stringedData = $type."...";
                            $count=0;
                        }
                        $stringedData .=" | ".$name." ".$value." ";
                        $count++;
                    }
                    $tickerData[] = $stringedData;
                }
            }
            @endphp
        @foreach($tickerData as $string) {
            <li>{{ $string }}</li>
        @endforeach
        </ul>
    </div>
</nav>
<script>
    $(window).on('load', function () {
        @if(! empty($stockLevels))
            $('.ticker').ticker();
        @endif
        $('.ticker').css('border', '1px solid blue;');
    });
</script>
