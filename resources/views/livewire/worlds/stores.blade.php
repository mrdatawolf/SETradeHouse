<div class="worldStores">
    <style>
        td {
            padding-right: 1em;
            font-family: Monospace, serif;
            font-size: smaller;
        }
        .serverGroup, .storeGroup {
            text-align: center;
        }
        .serverGroup, .left-border, .right-border {
            border: 0;
        }
        .left-border {
            border-left: 1px solid #ccc;

        }
        .right-border {
            border-right: 1px solid #ccc;
        }
        .exposureAlert {
            color: #9a1313;
        }
        .draw_attention {
            background-color: #d3f9e5 !important;
        }
        .draw_attention_border {
            border: 1px solid #2ba45f !important;
        }
    </style>
    @if(! empty($contentRows))
        <ul class="nav nav-tabs">
            @foreach(json_decode($contentRows) as $row)
                <li class="nav-item">
                    <a href="#{{ $row->JSID }}" class="nav-link {{ $row->active }}" data-toggle="tab">{{ $row->gridName }}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach(json_decode($contentRows) as $row)
                <div class="tab-pane fade {{ $row->SpecialClass }}" id="{{ $row->JSID }}">
                    <div class="card">
                        <div class="card-header">{{ $row->Owner }}</div>
                        <div class="card-body">
                            <ul class="nav nav-tabs">
                                @foreach($row->NavigationRows as $navrow)
                                    <li class="nav-item">
                                        <a href="#{{ $navrow->JSID }}_{{ $navrow->GoodType }}" class="nav-link {{ $navrow->ActiveClass }}" data-toggle="tab">{{ $navrow->GoodType }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($row->GoodTypeRows as $goodRow)
                                    <?php $goodType = $goodRow->GoodType;?>
                                    <div class="tab-pane fade {{ $goodRow->SpecialClasses }}" id="{{ $goodRow->JSID }}_{{ $goodRow->GoodType }}">
                                        @if(! empty($goodRow->Goods->$goodType))
                                            @livewire('stores.table',['goodRow' => json_encode($goodRow), 'goodType' => $goodType])
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $row->GPS }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
