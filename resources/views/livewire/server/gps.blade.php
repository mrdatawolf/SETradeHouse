<div class="card">
    <div class="card-header">Gps for @livewire('active-server')</div>
    <div class="card-body">
        <ul>
            @foreach($gpsMessages as $gps)
                <li>{{ $gps['message'] }} - {{ $gps['description'] }}</li>
            @endforeach
        </ul>
    </div>
</div>
