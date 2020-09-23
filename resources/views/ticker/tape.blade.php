<link href="{{ asset('css/ticker.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery.ticker.js') }}"></script>
<nav id="tickerBlock" class="navbar navbar-light bg-white shadow-sm fixed-bottom">
    <div class="ticker">
        <strong>Server Insights:</strong>
        <ul>
            @php
            $stockLevels    = \Session::get('stockLevels');
            $tickerData     = [];
            if(! empty($stockLevels)) {
                $maxCount       = 5;
                $count          = $maxCount+1;
                $stringedData   = "Gathering Data from around the Cluster...";
                $allowEntities = ($currentUser->roles->contains(8)) ? ['npc', 'user'] : ['npc'];
                foreach($stockLevels as $entityType => $entityData) {
                    if(in_array($entityType, $allowEntities)) {
                        foreach($entityData as $type => $data) {
                            if($count > 0) {
                                $tickerData[]   = $stringedData;
                                $stringedData   = $entityType . " - " . $type;
                                $count          = 0;
                            }
                            foreach($data as $name => $value) {
                                if($count > 5) {
                                    $tickerData[]   = $stringedData;
                                    $stringedData   = $entityType . " - " . $type;
                                    $count          = 0;
                                }
                                $stringedData .=" | ".$name." ".$value." ";
                                $count++;
                            }
                            $tickerData[] = $stringedData;
                        }
                    }
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
        @if(! empty($tickerData))
            $('.ticker').ticker();
        @endif
        $('.ticker').css('border', '1px solid blue;');
    });
</script>
