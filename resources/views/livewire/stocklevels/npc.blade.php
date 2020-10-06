<div class="card-columns">
    @foreach($stockLevels['npc'] as $goodType => $data)
    <div class="card">
        <div class="card-header text-center">{{ $goodType }}</div>
        <div class="card-body">
            <table class="table-striped">
                <thead>
                <tr>
                    <th>Good</th>
                    <th>Total Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $good => $amount)
                    <tr>
                        <td>{{ $good }}</td>
                        <td class="text-right">{{ $amount }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endforeach
</div>
