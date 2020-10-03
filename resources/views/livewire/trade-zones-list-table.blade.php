<table class="table-striped table-responsive-xl">
    <thead>
    <tr>
        <th>TZ Name</th>
        <th>Owner</th>
        <th>GPS</th>
    </tr>
    </thead>
    <tbody>
    @foreach(\App\Models\TradeZones::all() as $tradeZone)
        <tr>
            <td><a href="{{ route('store', ['id' => $tradeZone->id]) }}">{{ $tradeZone->title }}</a></td>
            <td>{{ $tradeZone->owner }}</td>
            <td>{{ $tradeZone->gps }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
