<table class="table-striped table-responsive-xl" style="width:100%">
    <thead>
    <tr>
        <th>Name</th>
        <th>Average Price</th>
        <th>Min Price</th>
        <th>Max Price</th>
        <th>Total in Transaction(s)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($gridData['Data'] as $group => $groupData)
        @foreach(['Offers','Orders'] as $type)
            <tr>
                <th colspan="5">{{ $group }} - {{ $type }}</th>
            </tr>
            @foreach($groupData[$type] as $item => $itemData)
            <tr>
                <td>{{ $item }}</td>
                <td>{{ number_format($gridData['Averages'][$group][$type][$item]['Price']) }}</td>
                <td>{{ number_format($gridData['Totals'][$group][$type][$item]['MinPrice']) }}</td>
                <td>{{ number_format($gridData['Totals'][$group][$type][$item]['MaxPrice']) }}</td>
                <td>{{ number_format($gridData['Totals'][$group][$type][$item]['Amount']) }}</td>
            </tr>
            @endforeach
        @endforeach
    @endforeach
    </tbody>
</table>
