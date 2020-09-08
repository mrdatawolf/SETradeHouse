@php $specialClasses = 'show active';  $specialClasses2 = 'show active'; @endphp
<style>
    td {
        padding-right: 1em;
    }
    .serverGroup, .left-border, .right-border {
        border: 1px solid #ccc;
    }
    .left-border, .right-border {
        border-top: 0;
        border-bottom: 0;
    }
    .serverGroup {
        border-bottom: 0;
        text-align: center;
    }
    .left-border {
        border-right: 0;

    }
    .right-border {
        border-left: 0;
    }
</style>
<ul class="nav nav-tabs">
    @php $active = 'active'; @endphp
    @foreach($gridData['Data'] as $group => $groupData)
            <li class="nav-item">
                <a href="#{{ $idName }}_{{ $group }}" class="nav-link {{ $active }}" data-toggle="tab">{{ $group }}</a>
            </li>
            @php $active = ''; @endphp
    @endforeach
</ul>
<div class="tab-content">
@foreach($gridData['Data'] as $group => $groupData)
    <div class="tab-pane fade {{ $specialClasses }}" id="{{ $idName }}_{{ $group }}">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="#{{ $idName}}_{{ $group }}_Offers" class="nav-link active" data-toggle="pill">Offers</a>
            </li>
            <li class="nav-item">
                <a href="#{{ $idName}}_{{ $group }}_Orders" class="nav-link" data-toggle="pill">Orders</a>
            </li>
        </ul>
        <div class="tab-content">
            @foreach(['Offers', 'Orders'] as $transactionType)
                <div class="tab-pane fade {{ $specialClasses2 }}" id="{{ $idName }}_{{ $group }}_{{ $transactionType }}">
                    <table class="table-striped table-responsive-xl transaction-table" style="width:100%">
                        <thead>
                            <tr class="transaction-table-groups">
                                <th colspan="2"></th>
                                <th colspan="2" class="serverGroup">Server</th>
                                <th colspan="3" class="serverGroup">Stores Transactions</th>
                            </tr>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Avg Price</th>
                                <th class="left-border">Average</th>
                                <th># TZs found</th>
                                <th class="left-border">Min Price</th>
                                <th>Max Price</th>
                                <th class="right-border">Total in Transaction(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($groupData[$transactionType] as $item => $itemData)
                            <tr class="text-right">
                                <td>{{ ucfirst($item) }}</td>
                                <td>{{ number_format($gridData['Averages'][$group][$transactionType][$item]['Price'] ?? 0) }}</td>
                                <td class="left-border">{{ number_format($globalAverages[$group][$transactionType][$item]['average'] ?? 0) }}</td>
                                <td>{{ number_format($globalAverages[$group][$transactionType][$item]['count'] ?? 0) }}</td>
                                <td class="left-border">{{ number_format($gridData['Totals'][$group][$transactionType][$item]['MinPrice'] ?? 0) }}</td>
                                <td>{{ number_format($gridData['Totals'][$group][$transactionType][$item]['MaxPrice'] ?? 0) }}</td>
                                <td class="right-border">{{ number_format($gridData['Totals'][$group][$transactionType][$item]['Amount'] ?? 0) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @php $specialClasses2 = 'hide'; @endphp
            @endforeach
        </div>
    </div>
    @php $specialClasses = 'hide'; @endphp
@endforeach
</div>
