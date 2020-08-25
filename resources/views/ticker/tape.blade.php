<nav class="navbar navbar-light bg-white shadow-sm fixed-bottom">
    <div class="ticker">
        <strong>Commodity Values:</strong>
        <ul>
            @php
            $stockLevels = \Session::get('stockLevels');
            $tickerData = [];
            foreach($stockLevels as $type => $data) {
                $stringedData = $type."...";
                foreach($data as $name => $value) {
                    $stringedData .=" | ".$name." ".$value." ";
                }
                $tickerData[] = $stringedData;
            }
            @endphp
        @foreach($tickerData as $string) {
            <li>{{ $string }}</li>
        @endforeach
        </ul>
    </div>
</nav>
