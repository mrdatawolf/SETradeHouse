<div>
    <nav id="tickerBlock" class="navbar navbar-light bg-white shadow-sm fixed-bottom">
        <div class="ticker">
            <strong>Server Insights:</strong>
            <ul>
                @php
                $stockController = new App\Http\Controllers\Stocklevels();
                $stockLevels    = $stockController->getStockLevels();
                $tickerData     = [];
                if(! empty($stockLevels)) {
                    $maxCount       = 5;
                    $count          = $maxCount+1;
                    $stringedData   = "Gathering Data from around the Cluster...";
                    $allowedEntities = ['npc'];

                    if($currentUser->roles->contains(8)) {
                        $allowedEntities[] = 'user';
                    }
                    foreach($stockLevels as $entityType => $entityData) {
                        if(in_array($entityType, $allowedEntities)) {
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
</div>
