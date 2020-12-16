<div class="card">
    <div class="card-header">Mods for @livewire('active-server')</div>
    <div class="card-body">
        <ol>
            @foreach($mods as $mod)
                <li>{{ $mod['message'] }} -
                    <ul>
                        <li>{{ $mod['description'] }}</li>
                        <li>{{ $mod['mod_type'] }}</li>
                        <li>{{ $mod['mod_number'] }}</li>
                    </ul>
                </li>
            @endforeach
        </ol>
    </div>
</div>
