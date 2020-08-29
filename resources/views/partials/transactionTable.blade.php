<ul class="nav nav-tabs">
    @php $active = 'active'; @endphp
    @foreach($gridData['Data'] as $group => $groupData)
            <li class="nav-item">
                <a href="#{{ $idName}}_{{ $group }}" class="nav-link {{ $active }}" data-toggle="tab">{{ $group }}</a>
            </li>
            @php $active = ''; @endphp
    @endforeach
</ul>
@php $specialClasses = 'show active'; @endphp
<div class="tab-content">
@foreach($gridData['Data'] as $group => $groupData)
    <div class="tab-pane fade {{ $specialClasses }}" id="{{ $idName}}_{{ $group }}">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="#{{ $idName}}_{{ $group }}_Offers" class="nav-link active" data-toggle="pill">Offers</a>
            </li>
            <li class="nav-item">
                <a href="#{{ $idName}}_{{ $group }}_Orders" class="nav-link" data-toggle="pill">Orders</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="{{ $idName}}_{{ $group }}_Offers">
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
                    @foreach($groupData['Offers'] as $item => $itemData)
                        <tr>
                            <td>{{ $item }}</td>
                            <td>{{ number_format($gridData['Averages'][$group]['Offers'][$item]['Price']) }}</td>
                            <td>{{ number_format($gridData['Totals'][$group]['Offers'][$item]['MinPrice']) }}</td>
                            <td>{{ number_format($gridData['Totals'][$group]['Offers'][$item]['MaxPrice']) }}</td>
                            <td>{{ number_format($gridData['Totals'][$group]['Offers'][$item]['Amount']) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade hide" id="{{ $idName}}_{{ $group }}_Orders">
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
                        @foreach($groupData['Orders'] as $item => $itemData)
                            <tr>
                                <td>{{ $item }}</td>
                                <td>{{ number_format($gridData['Averages'][$group]['Orders'][$item]['Price']) }}</td>
                                <td>{{ number_format($gridData['Totals'][$group]['Orders'][$item]['MinPrice']) }}</td>
                                <td>{{ number_format($gridData['Totals'][$group]['Orders'][$item]['MaxPrice']) }}</td>
                                <td>{{ number_format($gridData['Totals'][$group]['Orders'][$item]['Amount']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @php $specialClasses = ''; @endphp
@endforeach
</div>
