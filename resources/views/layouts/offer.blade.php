<html>
<head>
    <title>Offer - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/default.css') }}" rel="stylesheet">
    <link href="{{ asset('css/offer_order.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ticker.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body>
<div id="app">
    @extends('menu.menu')
    @extends('ticker.tape')
    <div class="container">
        <div class="panel panel-default">
            <!-- builder panel heading -->
            <div class="panel-heading">
                <H2>{{ $title }}</H2>
                <div class="pull-right">
                    <label for="set_amount">Override all amounts: </label><input id="set_amount" name="set_amount" type="text" value="1000"> <label for="set_modifier">Base Value Modifier: </label><input id="set_modifier" name="set_modifier" type="text" value="<?=$defaultMultiplier;?>" readonly>
                </div>
                <div>
                    <button onclick="exportTableTo('false', '{{ $exportTitle }}', 'csv')">Make CSV File</button>
                </div>
            </div>
            <div class="panel-body">
                <table style="margin-top: 5em; font-size: smaller" class="table table-bordered table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Item</th>
                        <th>Store Type</th>
                        <th>Price Per</th>
                        <th>Amount for sale</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        @if($item->se_name !== 'fillme')
                            <?php
                            $value = $item->getStoreAdjustedValue();
                            ?>
                            @if($value > 0 && $defaultMultiplier > 0)
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->se_name }}</td>
                                    <td>Offer</td>
                                    <td><span class="value editable">{{ round($value*$defaultMultiplier) }}</span></td>
                                    <td><span class="amount editable">{{ $defaultAmount }}</span></td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-body">
                <div id="userData">
                    <label class="btn btn-default col-btn-unchecked col-sel-btn" data-clipboard-target="#csv_text">Copy</label>
                    <h4><label for="csv_text">CSV Data</label></h4>
                    <textarea id="csv_text" class="textarea_csv"></textarea>
                </div>
            </div>
        </div>
        @yield('content')
    </div>
</div>
@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- <script src="https://kit.fontawesome.com/b61a9642d4.js" crossorigin="anonymous"></script> -->
    <script src="{{asset('js/default.js')}}"></script>
    <script src="/js/clipboard.min.js"></script>
    <script src="/js/offer_order.js"></script>
    <script src="/js/jquery.ticker.js"></script>
    <script>
        $(window).on('load', function () {
            $('.ticker').ticker();
            $('.ticker').css('border', '1px solid blue;');
            exportTableTo();
        });
    </script>
@show
</body>
</html>

